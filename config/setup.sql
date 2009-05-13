CREATE TABLE repositories (
       repoId int(5) NOT NULL auto_increment,
       url varchar(250) NOT NULL
       dateAdded date NOT NULL,
       dateUpdated date NOT NULL,
       description varchar(250),
       PRIMARY KEY (repo_id)
);

CREATE TABLE commits (
       commitId int(11) NOT NULL auto_increment,
       commit varchar(40) NOT NULL,
       message varchar(500) NOT NULL,
       commitDate datetime NOT NULL,
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