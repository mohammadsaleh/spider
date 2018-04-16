<?php
use Migrations\AbstractSeed;

/**
 * Settings seed.
 */
class SettingsSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => '1',
                'name' => 'site.title',
                'value' => 'Spider',
                'title' => 'Site Title',
                'description' => 'the title of site',
                'type' => 'text',
                'params' => NULL,
                'weight' => '2',
                'editable' => '1',
                'created_by' => '1',
                'updated_by' => NULL,
                'created' => '2017-05-07 15:14:57',
                'updated' => '2015',
            ],
            [
                'id' => '32',
                'name' => 'site.privacy',
                'value' => '<p>Write your privacy and policy here .....</p>
',
                'title' => 'Privacy Policy',
                'description' => NULL,
                'type' => 'textarea',
                'params' => '{"ckeditor":true}',
                'weight' => '1',
                'editable' => '1',
                'created_by' => '1',
                'updated_by' => NULL,
                'created' => '2017-05-07 15:14:57',
                'updated' => '0',
            ],
            [
                'id' => '36',
                'name' => 'site.status',
                'value' => 'online',
                'title' => 'Site Status',
                'description' => NULL,
                'type' => 'radio',
                'params' => '{"options":[{"text":"Offline","value":"offline","class":"control-warning"},{"text":"Online","value":"online","class":"control-info"}],"label":false,"div":false}',
                'weight' => '3',
                'editable' => '1',
                'created_by' => '1',
                'updated_by' => NULL,
                'created' => '2017-05-07 15:14:57',
                'updated' => '0',
            ],
        ];

        $table = $this->table('spider_settings_settings');
        $table->insert($data)->save();
    }
}
