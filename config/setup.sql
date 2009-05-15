CREATE TABLE repositories (
       repoId int(5) NOT NULL auto_increment,
       url varchar(250) NOT NULL,
       dateAdded date NOT NULL,
       dateUpdated date NOT NULL,
       description varchar(250),
       username varchar(50),
       password varchar(50),
       PRIMARY KEY (repoId)
);

CREATE TABLE commits (
       commitId int(11) NOT NULL auto_increment,
       repoId int(5) NOT NULL,
       commitVal varchar(40) NOT NULL,
       commitMessage varchar(500) NOT NULL,
       commitDateTime datetime NOT NULL,
       PRIMARY KEY (commitID)
);

CREATE TABLE fileChanges (
       fileChangeId int(11) NOT NULL auto_increment,
       commitId int(11) NOT NULL,
       file varchar(100) NOT NULL,
       PRIMARY KEY (fileChangeId)
);

CREATE TABLE users (
       userId int(5) NOT NULL auto_increment,
       username varchar(50) NOT NULL,
       password varchar(32) NOT NULL,
       PRIMARY KEY (userId )
);

CREATE TABLE watch (
       userId int(5) NOT NULL,
       repoId int(5) NOT NULL,
       PRIMARY KEY (userId, repoId )
);