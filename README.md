## Tambah Fitur Quiz 1 Minggu 5
https://youtu.be/-r6BJKWQuOk
## Tambah Fitur UTS Minggu 8
https://youtu.be/WomRn9B36yQ
## Tambah Fitur Quiz 2 Minggu 12
https://youtu.be/Kssr2gP2ZzM
## Create View
{{-- Copy This and paste on query localhost --}}<br>
CREATE VIEW hitung_count AS (SELECT comment_id,SUM(comment_likes.likes) AS total_likes FROM comment_likes
GROUP BY comment_id)
SELECT * FROM comments<br>
{{-- Copy This and paste on query localhost --}}