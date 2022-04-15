select m.name, m.year, a1.first_name, a1.last_name, r1.role, a2.first_name, a2.last_name, r2.role
from movies m
join roles r1 on r1.movie_id = m.id
join roles r2 on r2.movie_id = m.id
join actors a1 on a1.id = r1.actor_id
join actors a2 on a2.id = r2.actor_id
where r1.actor_id != r2.actor_id and m.id = 313459