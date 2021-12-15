# News Daffa Lara

## Landing page
<img src="/images_read/1.png" title="Screenshot dari HP 1"/>

## Landing page scrool
<img src="/images_read/2.png" title="Screenshot dari HP 2"/>

## Login page
<img src="/images_read/3.png" title="Screenshot dari HP 3"/>

## Landing page after LogIn
<img src="/images_read/4.png" title="Screenshot dari HP 4"/>

## Read More Article
<img src="/images_read/5.png" title="Screenshot dari HP 5"/>

## You can leave like and comment at each article
<img src="/images_read/6.png" title="Screenshot dari HP 6"/>

## There is two method of sorting comments
<img src="/images_read/7.png" title="Screenshot dari HP 7"/>

## You can delete your own comment
<img src="/images_read/8.png" title="Screenshot dari HP 8"/>

## Category filter page
<img src="/images_read/9.png" title="Screenshot dari HP 9"/>

## Search filter (db_like)
<img src="/images_read/10.png" title="Screenshot dari HP 10"/>

## News Daffa Lara

This Project is for my middle test using laravel framework,

You can leave a comment or ask for contributor if you want to help me grow. Thanks 

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