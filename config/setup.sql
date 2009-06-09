--     Copyright 2009, All Rights Reserved.

--     This file is part of Repository-Aggregator.

--     Repository-Aggregator is free software: you can redistribute it and/or modify
--     it under the terms of the GNU General Public License as published by
--     the Free Software Foundation, either version 3 of the License, or
--     (at your option) any later version.

--     Repository-Aggregator is distributed in the hope that it will be useful,
--     but WITHOUT ANY WARRANTY; without even the implied warranty of
--     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
--     GNU General Public License for more details.

--     You should have received a copy of the GNU General Public License
--     along with Repository-Aggregator.  If not, see <http://www.gnu.org/licenses/>.



CREATE TABLE repositories (
       repoId int(5) NOT NULL auto_increment,
       url varchar(250) NOT NULL,
       type int(5) NOT NULL,
       localDir varchar(250) NOT NULL,
       dateAdded date NOT NULL,
       dateUpdated date NOT NULL,
       description varchar(250),
       username varchar(50),
       password varchar(32),
       PRIMARY KEY (repoId)
);

CREATE TABLE commits (
       commitId int(11) NOT NULL auto_increment,
       repoId int(5) NOT NULL,
       commitVal varchar(40) NOT NULL,
       commitMessage varchar(500) NOT NULL,
       commitDateTime datetime NOT NULL,
			 author varchar(250) NOT NULL,
       PRIMARY KEY (commitID)
);

CREATE TABLE fileChanges (
       fileChangeId int(11) NOT NULL auto_increment,
       commitId int(11) NOT NULL,
       file varchar(100) NOT NULL,
       insertions int(5) NOT NULL,
       deletions int(5) NOT NULL,
       PRIMARY KEY (fileChangeId)
);

CREATE TABLE users (
       userId int(5) NOT NULL auto_increment,
       username varchar(50) NOT NULL,
       password varchar(32) NOT NULL,
       PRIMARY KEY (userId )
);

CREATE TABLE watches (
       userId int(5) NOT NULL,
       repoId int(5) NOT NULL,
       PRIMARY KEY (userId, repoId )
);
