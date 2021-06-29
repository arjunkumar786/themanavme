<?php

namespace Drupal\custom_module\Controller;

use Drupal\Core\Controller\ControllerBase;

class Connection extends ControllerBase {

  /**
   * Display the markup.
   *
   * @return array
   */
  public function content() {

    $link = mysqli_connect("127.0.0.1", "root", "rOOT@12345", "thedrupal");

    if (!$link) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }
    $query = "select n.nid,n.title,n.status,n.created,body.body_value from node as n join field_data_body as body on n.nid = body.entity_id";
    $result = mysqli_query($link, $query);

    /* numeric array */
    //$row = $result->fetch_array(MYSQLI_NUM);
    while($row = $result->fetch_array(MYSQLI_NUM)){
    kint($row);
    }
    //kint($row);

    return array(
      '#type' => 'markup',
      '#markup' => $this->t('Hello, World!'),
    );
  }

}
