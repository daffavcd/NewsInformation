## Tambah Fitur Minggu 5
https://youtu.be/-r6BJKWQuOk
## Tambah Fitur UTS Minggu 8
https://youtu.be/WomRn9B36yQ
## Create View
{{-- Copy This and paste on query localhost --}}
CREATE VIEW hitung_count AS (SELECT comment_id,SUM(comment_likes.likes) AS total_likes FROM comment_likes
GROUP BY comment_id)
SELECT * FROM comments
{{-- Copy This and paste on query localhost --}}