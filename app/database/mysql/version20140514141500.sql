ALTER TABLE club_user_profile CHANGE gender gender VARCHAR(255) DEFAULT NULL, CHANGE day_of_birth day_of_birth DATE DEFAULT NULL;
ALTER TABLE club_booking_plan ADD color VARCHAR(255) NOT NULL;
