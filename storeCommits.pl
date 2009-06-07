#!/usr/bin/env perl

#     Copyright 2009, All Rights Reserved.

#     This file is part of Repository-Aggregator.

#     Repository-Aggregator is free software: you can redistribute it and/or modify
#     it under the terms of the GNU General Public License as published by
#     the Free Software Foundation, either version 3 of the License, or
#     (at your option) any later version.

#     Repository-Aggregator is distributed in the hope that it will be useful,
#     but WITHOUT ANY WARRANTY; without even the implied warranty of
#     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#     GNU General Public License for more details.

#     You should have received a copy of the GNU General Public License
#     along with Repository-Aggregator.  If not, see <http://www.gnu.org/licenses/>.


use strict;
use warnings;
use Date::Parse;
use POSIX qw(strftime);

require Wrapper;

use DBI;			# Database
use Config::Abstract::Ini;	# Parse the config file

my $ini = new Config::Abstract::Ini( 'config/config.ini.php' );
my %values = $ini->get_entry( '' ); # Must supply '' because there are no "entries", only settings

# Assign values
my $data_source = 'dbi:mysql:'. $values{'dbName'} .':'. $values{'dbHostname'};
my $user = $values{ 'dbUsername' };
my $pass = $values{ 'dbPassword' };

# Connect
my $dbh = DBI->connect($data_source, $user, $pass, {
    PrintError => 1,
    AutoCommit => 1
		       }) 
    or die "Can't connect to the database: $DBI::errstr\n";

my $baseDir = $values{ 'repositoryDirectory' };

# Get all the repositories
my $sth = $dbh->prepare( 'SELECT type, localDir, repoId FROM repositories' );

$sth->execute();

my @row;
while(@row = $sth->fetchrow_array()) { # Get all of the repositories
  SWITCH:{
      if( $row[0] == 0 ) {	# Git Repository
	  storeGitCommits( $dbh, \@row, $baseDir );
	  last SWITCH;
      }
      if( $row[0] == 1 ) {	# Subversion Repository
	  storeSubversionCommits( \@row, $baseDir );
	  last SWITCH;
      }
      die 'Invalid repository type';
    }

} 





# Store a Git commit in the database
sub storeGitCommits {
	my ( $dbh, $data, $baseDir, $sql ) = @_;		# Get the data
	
  my $git = Git::Wrapper->new( $baseDir.'/'.@{$data}[1] ); # Create the Git Repo

	my @logs = $git->log( { numstat => 1 } );

	foreach my $log ( @logs ){
		# Find out if the commit already exists
		$sql = "SELECT COUNT(*) FROM commits WHERE repoId = @{$data}[2] AND commitVal = \"${$log}{id}\" LIMIT 1";
	
		my $sth = $dbh->prepare( $sql ); # Prepare and execute
		$sth->execute();
	
		my @row = $sth->fetchrow_array();
		if( $row[0] == 0 ) { # Only enter if it's not already there    

			my $datetime = getTime( ${$log}{attr}{date} );

			chomp( ${$log}{message} ); # Remove the trailing newline

		 	# Insert into database
	  	$sql = "INSERT INTO commits VALUES ( NULL, @{$data}[2], \"".$log->id."\", \"".$log->message."\", \"$datetime\" )";

			$sth = $dbh->prepare( $sql );
			$sth->execute();
	
			my $id = $dbh->last_insert_id( undef, undef, 'commits', undef );

			foreach my $filechange ( @{$log->filechanges} ){
				$sql = "INSERT INTO fileChanges VALUES ( NULL, $id, \"".$filechange->file."\", ".$filechange->insertions.", ".$filechange->deletions.")";

				$sth = $dbh->prepare( $sql );
				$sth->execute();
			}	
		}
	}  
}

sub storeSubversionCommits {
    ;
}


# Format the date for mysql datetime
sub getTime{
    my $time = shift;		# Get the time

    $time =~ m/(\w+)\s(\w+)\s(\d+)\s(.*?)\s/; # Match the parts we need

    # Format into Unix timestamp, then to datetime
    return strftime( "%Y-%m-%d %H:%M:%S", localtime( str2time( "$1 $3 $2 $4" ) ) );
}
