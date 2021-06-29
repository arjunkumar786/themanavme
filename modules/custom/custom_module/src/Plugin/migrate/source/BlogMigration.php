<?php
/**
 * @file
 * Contains \Drupal\custom_module\Plugin\migrate\source\BlogMigration.
 */

namespace Drupal\custom_module\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;
use Drupal\migrate\MigrateException;
use Drupal\migrate\Plugin\migrate\source\SourcePluginBase;
use Drupal\migrate\Plugin\MigrationInterface;
use Drupal\Core\Datetime\DrupalDateTime;

/**
 * Source for UserMigration from MS-SQL remotely.
 *
 * @MigrateSource(
 *   id = "blogmigration"
 * )
 */

 class BlogMigration extends SqlBase {

   /**
    * {@inheritdoc}
    */
   public function query() {
     // Source data is queried from 'curling_games' table.
     $query = $this->select('node', 'n');
     $query->Join('field_data_body', 'b', 'n.nid = b.entity_id');
     $query->fields('n', [
           'nid',
           'title',
           'status',
           'created',
         ]);
    $query->fields('b', [
         'body_value',
        ]);

     return $query;
   }

   /**
    * {@inheritdoc}
    */
   public function fields() {
     $fields = [
       'nid' => $this->t('Blog author id' ),
       'title' => $this->t('Blog title' ),
       'created' => $this->t('Blog created date' ),
       'status' => $this->t('Blog status' ),
       'body_value' => $this->t('Blog body' ),
     ];
     return $fields;
   }

   /**
    * {@inheritdoc}
    */
   public function getIds() {
     return [
       'nid' => [
         'type' => 'integer',
         'alias' => 'n',
       ],
     ];
   }

   /**
    * {@inheritdoc}
    */
   public function prepareRow(Row $row) {
     // This example shows how source properties can be added in
     // prepareRow(). The source dates are stored as 2017-12-17
     // and times as 16:00. Drupal 8 saves date and time fields
     // in ISO8601 format 2017-01-15T16:00:00 on UTC.
     // We concatenate source date and time and add the seconds.
     // The same result could also be achieved using the 'concat'
     // and 'format_date' process plugins in the migration
     // definition.

      $blog_date = $row->getSourceProperty('DateCreated');
      $date_utc = new DrupalDateTime($blog_date, 'UTC');
      $row->setSourceProperty('DateCreated', $date_utc->getTimestamp());
      return parent::prepareRow($row);
   }
 }
