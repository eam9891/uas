CREATE TABLE users
(
  username VARCHAR(64) NOT NULL,
  password VARCHAR(64) NOT NULL,
  email VARCHAR(64),
  role VARCHAR(64),
  salt VARCHAR(64),
  userID INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  active TINYINT(1) DEFAULT '0',
  avatar BLOB,
  activityTime VARCHAR(64) DEFAULT CURRENT_TIMESTAMP NOT NULL
);

CREATE TABLE blogPosts
(
  postID INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  postTitle VARCHAR(255) NOT NULL,
  postContent TEXT,
  postDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  postAuthor VARCHAR(64),
  postPublished TINYINT(1) DEFAULT '0',
  readyForReview TINYINT(1) DEFAULT '0',
  authorID INT(11) DEFAULT '1',
  viewCount INT(11),
  CONSTRAINT blogPosts_users_userID_fk FOREIGN KEY (authorID) REFERENCES users (userID)
);



CREATE TABLE blogPostComments
(
  commentID INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  postID INT(11) NOT NULL,
  user VARCHAR(64) NOT NULL,
  comment TEXT,
  commentDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  CONSTRAINT blogComments_blogPosts_postID_fk FOREIGN KEY (postID) REFERENCES blogPosts (postID)
);

CREATE TABLE blogPostCommentReplies
(
  replyID INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  commentID INT(11),
  userID INT(11),
  reply INT(11),
  replyDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  CONSTRAINT blogPostCommentReplies_blogPostComments_commentID_fk FOREIGN KEY (commentID) REFERENCES blogPostComments (commentID),
  CONSTRAINT blogPostCommentRepliesUser___fk FOREIGN KEY (userID) REFERENCES users (userID)
);

CREATE TABLE chat
(
  userID INT(11),
  message TEXT,
  author VARCHAR(255),
  messageDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  messageRead TINYINT(1) DEFAULT '0',
  contactID INT(11),
  id INT(11) NOT NULL AUTO_INCREMENT,
  messageDeleted TINYINT(1) DEFAULT '0',
  actionUser INT(11),
  chatRoomID INT(11),
  CONSTRAINT chat_users_userID_fk FOREIGN KEY (userID) REFERENCES users (userID),
  CONSTRAINT chat_contactID_userID_fk FOREIGN KEY (contactID) REFERENCES users (userID),
  CONSTRAINT chat_chatRooms_chatRoomID_fk FOREIGN KEY (chatRoomID) REFERENCES chatRooms (chatRoomID)
);

CREATE TABLE chatRooms
(
  chatRoomID INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  chatRoomKey VARCHAR(64)
);

CREATE TABLE contacts
(
  contactID INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  userOne INT(11),
  userTwo INT(11),
  status INT(11),
  actionUserID INT(11)
);

CREATE TABLE postCategories
(
  categoryID INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  postID INT(11),
  category VARCHAR(64),
  CONSTRAINT postCategories_blogPosts_postID_fk FOREIGN KEY (postID) REFERENCES blogPosts (postID)
);
CREATE TABLE postTags
(
  postID INT(11),
  tagID INT(11),
  CONSTRAINT postTags_blogPosts_postID_fk FOREIGN KEY (postID) REFERENCES blogPosts (postID),
  CONSTRAINT postTags_tags_tagID_fk FOREIGN KEY (tagID) REFERENCES tags (tagID)
);
CREATE TABLE tags
(
  tagID INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  tagTitle VARCHAR(64) NOT NULL,
  tagHtml TEXT
);



CREATE UNIQUE INDEX blogComments_commentID_uindex ON blogPostComments (commentID);
CREATE INDEX blogComments_users_userID_fk ON blogPostComments (user);
CREATE INDEX blogComments_blogPosts_postID_fk ON blogPostComments (postID);

CREATE UNIQUE INDEX front_blog_postID_uindex ON blogPosts (postID);
CREATE INDEX blogPosts_users_userID_fk ON blogPosts (authorID);
CREATE UNIQUE INDEX blogPosts_postTitle_uindex ON blogPosts (postTitle);

CREATE UNIQUE INDEX chat_chatID_uindex ON chat (id);
CREATE INDEX chat_users_userID_fk ON chat (userID);
CREATE INDEX chat_contactID_userID_fk ON chat (contactID);
CREATE INDEX chat_chatRooms_chatRoomID_fk ON chat (chatRoomID);

CREATE UNIQUE INDEX chatRooms_chatRoomID_uindex ON chatRooms (chatRoomID);
CREATE UNIQUE INDEX contacts_contactID_uindex ON contacts (contactID);

CREATE UNIQUE INDEX users_id_uindex ON users (userID);
CREATE UNIQUE INDEX users_username_uindex ON users (username);

CREATE INDEX blogPostCommentRepliesUser___fk ON blogPostCommentReplies (userID);
CREATE INDEX blogPostCommentReplies_blogPostComments_commentID_fk ON blogPostCommentReplies (commentID);
CREATE UNIQUE INDEX postCommentReplies_replyID_uindex ON blogPostCommentReplies (replyID);

CREATE UNIQUE INDEX tags_tagID_uindex ON tags (tagID);
CREATE UNIQUE INDEX tags_tagTitle_uindex ON tags (tagTitle);

CREATE INDEX postTags_blogPosts_postID_fk ON postTags (postID);
CREATE INDEX postTags_tags_tagID_fk ON postTags (tagID);

CREATE UNIQUE INDEX postCategories_categoryID_uindex ON postCategories (categoryID);
CREATE INDEX postCategories_blogPosts_postID_fk ON postCategories (postID);
