<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=472812626151651";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="fb-facepile" data-href="https://www.facebook.com/pages/The-Gaylord-Restaurant/219983038085736?rf=127973883918936" data-max-rows="5" data-colorscheme="light" data-size="large" data-show-count="true"></div>

</body>
</html>
SELECT
    o_id,
    SUM(IF(o_paymentType= 'Cash', o_total, 0)) AS 'Cash',
    SUM(IF(o_paymentType= 'Card', o_total, 0)) AS 'Card',

    SUM(o_total) AS SumTotal
FROM
    order_tbl
WHERE
    o_date= '2014-03-09'
GROUP BY
    o_id