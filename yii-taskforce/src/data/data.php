<?php

require_once('./ImportData.php');

// $dataCategories = new ImportData();
// $dataCategories->getFormattedData($dataCategories->formatData('../../data/opinions.csv', ['author_id']), 'opinions');



// $dataCities = new ImportData('../../data/cities.csv', 'cities');
// $dataCities->getFormattedData($dataCities->getArrayData($dataCities->getPath()), $dataCities->getCatigories());

// $dataOpinions = new ImportData('../../data/opinions.csv', 'opinions');
// $dataOpinions->getFormattedData($dataOpinions->getArrayData($dataOpinions->getPath()), $dataOpinions->getCatigories());

// $dataProfiles = new ImportData('../../data/profiles.csv', 'profiles');
// $dataProfiles->getFormattedData($dataProfiles->getArrayData($dataProfiles->getPath()), $dataProfiles->getCatigories());

// $dataReplies = new ImportData('../../data/replies.csv', 'replies');
// $dataReplies->getFormattedData($dataReplies->getArrayData($dataReplies->getPath()), $dataReplies->getCatigories());

// $dataTasks = new ImportData('../../data/tasks.csv', 'tasks');
// $dataTasks->getFormattedData($dataTasks->getArrayData($dataTasks->getPath()), $dataTasks->getCatigories());

// $dataUsers = new ImportData('../../data/users.csv', 'users');
// $dataUsers->getFormattedData($dataUsers->getArrayData($dataUsers->getPath()), $dataUsers->getCatigories());

// $dataCategories = ImportData::formatData('../../data/categories.csv');
ImportData::getFormattedData(ImportData::formatData('../../data/categories.csv'), 'categories');
ImportData::getFormattedData(ImportData::formatData('../../data/cities.csv'), 'cities');
ImportData::getFormattedData(ImportData::formatData('../../data/users.csv', ['city_id']), 'users');
ImportData::getFormattedData(ImportData::formatData('../../data/tasks.csv', ['city_id', 'user_id']), 'tasks');
ImportData::getFormattedData(ImportData::formatData('../../data/profiles.csv', ['user_id']), 'profiles');
ImportData::getFormattedData(ImportData::formatData('../../data/opinions.csv', ['author_id']), 'opinions');
ImportData::getFormattedData(ImportData::formatData('../../data/replies.csv', ['author_id', 'task_id']), 'replies');


