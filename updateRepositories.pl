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

use Git::Wrapper;

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

my $sth = $dbh->prepare( 'SELECT type, localDir, username, password FROM repositories' );

$sth->execute();

my @row;
while(@row = $sth->fetchrow_array()) {
  SWITCH:{
      if( $row[0] == 0 ) {	# Git Repository
	  updateGitRepository( \@row, $baseDir );
	  last SWITCH;
      }
      if( $row[0] == 1 ) {	# Subversion Repository
	  updateSubversionRepository( \@row, $baseDir );
	  last SWITCH;
      }
      die 'Invalid repository type';
    }

} 






sub updateGitRepository {
    my $data = shift;		# Get the data
    my $baseDir = shift;

    my $git = Git::Wrapper->new( $baseDir.'/'.@{$data}[1] ); # Create the Git Repo

    $git->pull;			# Update
}

sub updateSubversionRepository {
    ;
}
