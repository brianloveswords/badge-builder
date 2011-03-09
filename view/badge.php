<?php
  require_once('_findbadge.php');
  require_once('../classes/badgescript.php');
?>
<!doctype html>
<html>
  <head>
    <title>Badge Builder</title>
    <link rel="stylesheet" type="text/css" href="../stylesheet.css">
  </head>
  <body>
    <a href="/" role='back-link'>&larr; Back to Builder</a>
    <div role='container'>
      <h1>Badge Builder</h1>
      <p role='description'>
        Here is your badge, as well as code to put it on any personal website,
        or send to someone else to put on their website. Once added to a site,
        the badge will contain all of the information that you included when
        you created the badge, including the link back to the evidence you
        provided. You can point people to your badge to communicate and
        demonstrate that particular skill, achievement, quality or
        affiliation.
      </p>
      <?php print $script->snippet(); ?>
      <textarea><?php print $script->snippet(); ?></textaera>
    </div>
  </body>
</html>