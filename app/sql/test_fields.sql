INSERT INTO club_booking_field (location_id, name, position, terms, created_at, updated_at) VALUES
  (2, 'Bane 1', 1, 'Ingen adgang uden sko.', now(), now()),
  (2, 'Bane 2', 2, 'Ingen adgang uden sko.', now(), now()),
  (2, 'Bane 3', 3, 'Ingen adgang uden sko.', now(), now()),
  (2, 'Bane 4', 4, 'Ingen adgang uden sko.', now(), now());

INSERT INTO club_booking_day (field_id, day, open_time, close_time, created_at, updated_at) VALUES
  (1, 1, '08:00', '21:00', now(), now()),
  (1, 2, '08:00', '21:00', now(), now()),
  (1, 3, '08:00', '21:00', now(), now()),
  (1, 4, '08:00', '21:00', now(), now()),
  (1, 5, '08:00', '21:00', now(), now()),
  (2, 1, '08:00', '21:00', now(), now()),
  (2, 2, '08:00', '21:00', now(), now()),
  (2, 3, '08:00', '21:00', now(), now()),
  (2, 4, '08:00', '21:00', now(), now()),
  (2, 5, '08:00', '21:00', now(), now()),
  (3, 1, '08:00', '21:00', now(), now()),
  (3, 2, '08:00', '21:00', now(), now()),
  (3, 3, '08:00', '21:00', now(), now()),
  (3, 4, '08:00', '21:00', now(), now()),
  (3, 5, '08:00', '21:00', now(), now()),
  (4, 1, '08:00', '21:00', now(), now()),
  (4, 2, '08:00', '21:00', now(), now()),
  (4, 3, '08:00', '21:00', now(), now()),
  (4, 4, '08:00', '21:00', now(), now()),
  (4, 5, '08:00', '21:00', now(), now());

INSERT INTO club_booking_interval (day_id, start_time, stop_time, created_at, updated_at) VALUES
  (1,'08:00','16:00',now(),now()),
  (1,'16:00','21:00',now(),now()),
  (2,'08:00','16:00',now(),now()),
  (2,'16:00','21:00',now(),now()),
  (3,'08:00','16:00',now(),now()),
  (3,'16:00','21:00',now(),now()),
  (4,'08:00','16:00',now(),now()),
  (4,'16:00','21:00',now(),now()),
  (5,'08:00','16:00',now(),now()),
  (5,'16:00','21:00',now(),now());
