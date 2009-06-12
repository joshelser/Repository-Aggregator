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
use Config::Abstract::Ini;

my $ini = new Config::Abstract::Ini( 'config/config.ini.php' );
my %values = $ini->get_entry( '' );

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

my $sql = 'SELECT localDir FROM repositories WHERE repoId=' . $dbh->quote( $repoId ) . ' LIMIT 1';

my $sth = $dbh->prepare( $sql );
$sth->execute();

my @row = $sth->fetchrow_array();

my $output = `git show`;
createGitRepository( $url, $values{'repositoryDirectory'}.$repoDir );

sub createGitRepository {
	my $url = shift;
	my $dir = shift;

	system( ( 'git', 'clone', $url, $repoDir ) );
}
