#!/usr/bin/env perl

use strict;
use warnings;

use Git::Wrapper;

use DBI;			# Database
use Config::Abstract::Ini;	# Parse the config file

my $ini = new Config::Abstract::Ini( 'config/config.ini.php' );
my %values = $ini->get_entry( '' ); # Must supply '' because there are no "entries", only settings

foreach ( keys %values ) {
    print "'$_' => '$values{$_}'\n";
}

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

my $baseUrl = $values{ 'respositoryDirectory' };

my $sth = $dbh->prepare( 'SELECT type, localDir, username, password FROM repositories' );

$sth->execute();

my @row;
while(@row = $sth->fetchrow_array()) {
  SWITCH:{
      if( $row[0] == 0 ) {	# Git Repository
	  updateGitRepository( @row );
	  last SWITCH;
      }
      if( $row[0] == 1 ) {	# Subversion Repository
	  updateSubversionRepository( @row );
	  last SWITCH;
      }
      die 'Invalid repository type';
    }

    print "$row[0]: $row[1]\n";
} 






sub updateGitRepository {
    my @data = @_;		# Get the data
    
    my $git = Git::Wrapper->new( $data[1] );
}

sub updateSubversionRepository {
    ;
}
