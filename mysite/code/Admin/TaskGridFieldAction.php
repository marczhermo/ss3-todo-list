<?php

class TaskGridFieldAction implements GridField_ColumnProvider, GridField_ActionProvider
{
    /**
     * {@inheritdoc}
     */
    public function augmentColumns($gridField, &$columns)
    {
        if (!in_array('Actions', $columns)) {
            $columns[] = 'Actions';
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getColumnAttributes($gridField, $record, $columnName)
    {
        return array('class' => 'col-buttons');
    }

    /**
     * {@inheritdoc}
     */
    public function getColumnMetadata($gridField, $columnName)
    {
        if ($columnName == 'Actions') {
            return array('title' => '');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getColumnsHandled($gridField)
    {
        return array('Actions');
    }

    /**
     * {@inheritdoc}
     */
    public function getColumnContent($gridField, $record, $columnName)
    {
        if (!$record->canEdit()) {
            return;
        }

        $field = "";

        if ($record->ClassName === 'TodoTask') {
            $formAction = GridField_FormAction::create(
                $gridField,
                'CustomAction' . $record->ID . 'Hello',
                'Ajax?',
                'hello',
                array('RecordID' => $record->ID)
            );
            $formAction->setUseButtonTag(true)
                ->addExtraClass('ss-ui-button task-grid-button')
                ->setAttribute('data-icon', 'pencil');

            $field .= $formAction->Field();
        }

        TaskAdminView::include_requirements();

        return $field;
    }

    /**
     * {@inheritdoc}
     */
    public function getActions($gridField)
    {
        return array('hello');
    }

    /**
     * {@inheritdoc}
     */
    public function handleAction(GridField $gridField, $actionName, $arguments, $data)
    {
        if ($actionName == 'hello') {
            $task = TodoTask::get()->byID($arguments["RecordID"]);
            $task->Title;

            // output a success message to the user
            Controller::curr()->getResponse()->setStatusCode(
                200,
                'Success :) ' . $actionName . "<br>" . $task->Title . "<br>" . var_export($arguments, 1)
            );
        }
    }
}
