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

# DBI and Ini parsing
use DBI;
use Config::Abstract::Ini;

my $ini = new Config::Abstract::Ini( 'config/config.ini.php' );
my %values = $ini->get_entry( '' );

# Make sure the script is used properly
if( @ARGV != 3 ) {
	die( "Usage: ./getFileChange.pl repositoryId revisionId filename\n" );
}

my ( $repoId, $revId, $filename ) = @ARGV;

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

# Get the local directory for the repository
my $sql = 'SELECT localDir FROM repositories WHERE repoId=' . $dbh->quote( $repoId ) . ' LIMIT 1';

my $sth = $dbh->prepare( $sql );
$sth->execute();

my @row = $sth->fetchrow_array();

$sql = 'SELECT commitVal FROM commits WHERE commitId = ' . $dbh->quote( $revId ) . ' LIMIT 1';

$sth = $dbh->prepare( $sql );
$sth->execute();

my @row2 = $sth->fetchrow_array();

# Sanity check on the git ID given
if( $row2[0] !~ m/(\d|[a-z]){40}/ ){
	die 'Invalid commit ID was given';
}

# For now, just execute the git command as a shell script
my $repoDir = $values{ 'repositoryDirectory' } . '/' . $row[0];
my $output = `cd $repoDir && git show --pretty=format:"%n" $row2[0] $filename`;

print ltrim( $output );

# Left trim function to remove leading whitespace
sub ltrim {
	my $string = shift;
	$string =~ s/^\s+//;
	return $string;
}

