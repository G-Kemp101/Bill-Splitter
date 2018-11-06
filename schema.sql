DROP TABLE users;
CREATE TABLE users(userid integer primary key, name varchar(10), email varchar(40), salt text, password text, groupId integer, bitch integer);

DROP TABLE bills;
CREATE TABLE bills(billid integer primary key, paidby integer, billDesc text, amount integer);

DROP TABLE relations;
CREATE TABLE relations(user1 integer, user2 integer, debt integer);

DROP TABLE userBills;
CREATE TABLE userBills(user_id integer, bill_id integer, amount integer, status integer, foreign key(user_id) references users(userid), foreign key(bill_id) references bills(billid));

DROP TABLE notes;
CREATE TABLE notes(noteid integer primary key, user_id integer, noteTitle text, note text, dateCreated text, foreign key(user_id) references users(userid));
