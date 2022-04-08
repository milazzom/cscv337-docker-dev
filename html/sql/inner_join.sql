# This is the ID for Star Wars:  313459
# We want to get all the actors that were in the movie Star Wars

select a.id, a.first_name, a.last_name, m.name, m.year
from actors as a 
JOIN roles r on a.id = r.actor_id 
JOIN movies m on m.id = r.movie_id
WHERE m.name = "Star Wars"
ORDER BY a.last_name asc