CREATE DATABASE elearn;
use elearn;
CREATE TABLE Learner (
    LearnerID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100) NOT NULL,
    Email VARCHAR(100) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL
);
-------------------------
CREATE TABLE ITFields (
    FieldID INT AUTO_INCREMENT PRIMARY KEY,
    FieldName VARCHAR(100) NOT NULL
);
INSERT INTO ITFields (FieldName) VALUES 
('Software Developer'),
('DevOps'),
('Network Security'),
('Database Administration'),
('Software Tester');

-------------------------
CREATE TABLE Courses (
    CourseID INT AUTO_INCREMENT PRIMARY KEY,
    CourseName VARCHAR(200) NOT NULL,
    FieldID INT,
    Provider TEXT,  -- Renamed from Description
    URL VARCHAR(255),
    IsFree BOOLEAN,
    Duration VARCHAR(50),
    FOREIGN KEY (FieldID) REFERENCES ITFields(FieldID)
);

-------------------------
CREATE TABLE Certifications (
    CertificationID INT AUTO_INCREMENT PRIMARY KEY,
    CertificationName VARCHAR(200) NOT NULL,
    certification_url VARCHAR(500),
    FieldID INT,
    FOREIGN KEY (FieldID) REFERENCES ITFields(FieldID)
);

-------------------------
CREATE TABLE LearnerFields (
    LearnerFieldID INT AUTO_INCREMENT PRIMARY KEY,
    LearnerID INT,
    FieldID INT,
    FOREIGN KEY (LearnerID) REFERENCES Learner(LearnerID),
    FOREIGN KEY (FieldID) REFERENCES ITFields(FieldID)
);

-------------------------

CREATE TABLE ChatSessions (
    SessionID INT AUTO_INCREMENT PRIMARY KEY,
    LearnerID1 INT,
    LearnerID2 INT,
    FieldID INT,
    StartTime DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (LearnerID1) REFERENCES Learner(LearnerID),
    FOREIGN KEY (LearnerID2) REFERENCES Learner(LearnerID),
    FOREIGN KEY (FieldID) REFERENCES ITFields(FieldID)
);

---------------------------

CREATE TABLE ChatMessages (
    MessageID INT AUTO_INCREMENT PRIMARY KEY,
    SessionID INT,
    SenderLearnerID INT,
    MessageText TEXT,
    Timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (SessionID) REFERENCES ChatSessions(SessionID),
    FOREIGN KEY (SenderLearnerID) REFERENCES Learner(LearnerID)
);
