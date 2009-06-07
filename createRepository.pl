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

if( @ARGV != 3 ) {
	die( "Usage: ./createRepository type url path\n" );
}

my ( $type, $url, $repoDir ) = @ARGV;

createGitRepository( $url, $repoDir );

sub createGitRepository {
	my $url = shift;
	my $dir = shift;

	system( ( 'git', 'clone', $url, $repoDir ) );
}
