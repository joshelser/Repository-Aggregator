#!/usr/bin/env perl

use strict;
use warnings;
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

my $sth = $dbh->prepare( 'SELECT * from repositories' );

$sth->execute();

my @row;
while(@row = $sth->fetchrow_array()) {
    print "$row[0]: $row[1] $row[2] $row[3] $row[4]\n";
} 
