CREATE TABLE User (
	`Email` 	VARCHAR(50) 	NOT NULL,
	`First_Name` 	VARCHAR(30)	NOT NULL,
	`Last_Name`	VARCHAR(30)	NOT NULL,
	`Password`	VARCHAR(30)	NOT NULL,
	PRIMARY KEY(`Email`)
);

CREATE TABLE Regular_User (
	`Email`		VARCHAR(50)	NOT NULL,
	`Sex`		CHAR(1)		NOT NULL,
	`Birth_Date`	DATE		NOT NULL,
	`Current_City`	VARCHAR(25)	NOT NULL,
	`Hometown`	VARCHAR(25)	NOT NULL,
	PRIMARY KEY(`Email`),
	FOREIGN KEY(`Email`) REFERENCES `User`(`Email`),
	CONSTRAINT Birth_Date CHECK DATEDIFF(CURDATE(), Birth_Date) > 0
);

CREATE TABLE Admin (
	`Email`		VARCHAR(50)	NOT NULL,
	`Last_Login`	DATETIME,
	PRIMARY KEY(`Email`),
	FOREIGN KEY(`Email`) REFERENCES `User`(`Email`)
);

CREATE TABLE Regular_User_Interest (
	`Email`		VARCHAR(50)	NOT NULL,
	`Interest`	VARCHAR(50)	NOT NULL,
	PRIMARY KEY(`Email`,`Interest`),
	FOREIGN KEY(`Email`) REFERENCES `Regular_User`(`Email`),
);

CREATE TABLE Regular_User_School (
	`Email`		VARCHAR(50)	NOT NULL,
	`School_Name`	VARCHAR(40)	NOT NULL,
	`Year_Graduated` DATE,
	PRIMARY KEY(`Email`, `School_Name`, `Year_Graduated`),
	FOREIGN KEY(`Email`) REFERENCES `Regular_User`(`Email`),
	FOREIGN KEY(`School_Name`) REFERENCES `School`(`Name`)
);

CREATE TABLE School (
	`Name`		VARCHAR(40)	NOT NULL,
	`Type`		VARCHAR(20)	NOT NULL,
	PRIMARY KEY(`Name`),
	FOREIGN KEY(`Type`) REFERENCES `School_Type`(`Name`)
);

CREATE TABLE Friendship (
	`User_Email`	VARCHAR(50)	NOT NULL,
	`Friend_Email`	VARCHAR(50)	NOT NULL,
	`Relationship`	VARCHAR(20)	NOT NULL,
	`Date_Connected` DATE,
	PRIMARY KEY(`User_Email`, `Friend_Email`),
	FOREIGN KEY(`User_Email`) REFERENCES `Regular_User`(`Email`),
	FOREIGN KEY(`Friend_Email`) REFERENCES `Regular_User`(`Email`)
);

CREATE TABLE School_Type (
	`Name`		VARCHAR(20)	NOT NULL,
	PRIMARY KEY(`Name`)
);

CREATE TABLE Regular_User_Job (
	`Email`		VARCHAR(50)	NOT NULL,
	`Employer_Name`	VARCHAR(50)	NOT NULL,
	`Job_Title`	VARCHAR(25)	NOT NULL,
	PRIMARY KEY(`Email`, `Employer_Name`),
	FOREIGN KEY(`Email`) REFERENCES `Regular_User`(`Email`),
	FOREIGN KEY(`Employer_Name`) REFERENCES `Employer`(`Name`)
);

CREATE TABLE Employer (
	`Name`		VARCHAR(50)	NOT NULL,
	PRIMARY KEY(`Name`)
);

CREATE TABLE Status_Update (
	`Email`		VARCHAR(50)	NOT NULL,
	`Date_And_Time`	DATETIME	NOT NULL,
	`Text`		VARCHAR(200)	NOT NULL,
	PRIMARY KEY(`Email`, `Date_And_Time`),
	FOREIGN KEY(`Email`) REFERENCES `Regular_User`(`Email`)
);

CREATE TABLE Status_Comment (
	`Update_Email`		VARCHAR(50)	NOT NULL,
	`Update_Date_And_Time` 	DATETIME	NOT NULL,
	`Comment_Email`		VARCHAR(50)	NOT NULL,
	`Comment_Date_And_Time`	DATETIME	NOT NULL,
	`Text`			VARCHAR(200)	NOT NULL,
	PRIMARY KEY(`Update_Email`, `Update_Date_And_Time`, `Comment_Email`, `Comment_Date_And_Time`),
	FOREIGN KEY(`Update_Email`, `Update_Date_And_Time`) REFERENCES `Status_Update`(`Email`, `Date_And_Time`),
	FOREIGN KEY(`Comment_Email`) REFERENCES `Regular_User`(`Email`)
);
