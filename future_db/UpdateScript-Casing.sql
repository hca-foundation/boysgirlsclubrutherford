UPDATE volunteer SET first_name = LOWER(first_name);
UPDATE volunteer SET last_name = LOWER(last_name);
UPDATE volunteer SET email = LOWER(email);
select * from volunteer;