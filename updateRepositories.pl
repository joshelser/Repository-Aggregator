#!/usr/bin/env perl

use strict;
use warnings;

use Git::Wrapper;
use Git::PurePerl;

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
	  updateSubversionRepository( @row );
	  last SWITCH;
      }
      die 'Invalid repository type';
    }

} 






sub updateGitRepository {
    my $data = shift;		# Get the data
    my $baseDir = shift;

    my $git = Git::Wrapper->new( $baseDir.'/'.@{$data}[1] );

    $git->pull;
}

sub updateSubversionRepository {
    ;
}
