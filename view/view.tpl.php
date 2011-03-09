<!doctype html>
<html>
  <head>
    <title>Badge Builder</title>
    <link rel="stylesheet" type="text/css" href="../stylesheet.css">
  </head>
  <body>
    <a href="/" role='back-link'>&larr; Back to Beginning</a>
    <div role='container'>
      <h1>Badge Builder</h1>
      <p role='description'>
        Here is a list of all of the badges people have made.
      </p>
      <ul role='badge-list'>
        <?php foreach ($badges as $badge): ?>
        <li><?php print($badge->snippet()); ?></li>
        <?php endforeach; ?>
        
        <?php if (empty($badges)): ?>
        <h3>No badges yet :(</h3>
        <?php endif; ?>
      </ul>
   </div>
  </body>
</html>




