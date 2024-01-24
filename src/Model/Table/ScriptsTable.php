<?php

namespace App\Model\Table;

use Cake\Datasource\ConnectionManager;
use Cake\ORM\Table;
use Cake\Log\Log;
use Cake\I18n\FrozenTime;

class ScriptsTable extends Table
{
    public function initialize(array $config)
    {
        // not really needed since they're assumed by default
        $this->setTable('scripts');
        // $this->setEntityClass('App\Model\Entity\InputDataFall');
        // $this->setPrimaryKey('id');        
    }

    public function getAll()
    {
        $query = $this->find('all');

        return $query;
    }

    public function getIpListScriptOrCreate()
    {
        $query = $this->find();
        $query->select('last_change');
        $query->where(['name' => 'ip_list_update']);
        $result = $query->first();

        if (!$result) {
            Log::debug('no ip_list_update script found...creating');

            $this->query()
                ->insert(['name', 'last_change'])
                ->values([
                    'name' => 'ip_list_update',
                    'last_change' => FrozenTime::now()->i18nFormat('yyyy-MM-dd HH:mm:ss')
                ])
                ->execute();
        }

        return $result ? $result['last_change'] : null;
    }

    public function refreshIpListScript()
    {
        Log::debug('refreshing ip_list_update...');

        $this->query()
            ->update()
            ->set(['last_change' => FrozenTime::now()->i18nFormat('yyyy-MM-dd HH:mm:ss')])
            ->where(['name' => 'ip_list_update'])
            ->execute();
    }
}
