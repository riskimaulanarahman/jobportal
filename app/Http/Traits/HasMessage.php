<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;


trait HasMessage {

    /**
     * @param Request $request
     * @return $this|false|string
     */
    public function getMessage(): array {

        $message = [
            'show' => 'The data is being displayed.',
            'store' => 'Data has been successfully added.',
            'update' => 'The data was successfully changed.',
            'destroy' => 'Data was successfully deleted.',
            'errordestroysubmission' => 'This data has a relation with others or data does not belong to you, that is still being used. You are not allowed to delete it.',
            'erroruploadimages' => 'Invalid file. Please upload a valid image file.',
            'errornotfound' => 'Data Not Found.',
            'modulenotfound' => 'Module Not Found.',
            'usernotregistered' => 'User Not Registered.',
            'assignmentnotfound' => 'Error: Assignment not found, Please add it to continue.',
            'userexist' => 'User already exist.',
            'chairmanexist' => 'Chairman already exist.',
            'buyerexist' => 'The buyer already exists. Only one buyer can be added.',
            'nothaveaccess' => 'Error: Unauthorized Access - You do not have the necessary permissions to perform this action.',
            'accessformanageronly' => 'Error: Unauthorized Access - Only for Manager Up, You do not have the necessary permissions to perform this action.',
            'usernotregisteredldap' => 'User Not Registered on LDAP.',
        ];

        return $message;

    }

    public function mailMessage(): array {

        $message = [
            'approved' => 'Your submission has been approved and will be processed further.',
            'rejected' => 'We are sorry to inform you that your submission has been rejected. Please check your submission again and reapply if necessary.',
            'reworked' => 'Your submission requires improvement and needs to be fixed according to the notes that have been given.',
            'cancelled' => 'We regret to inform you that your submission has been cancelled.',
            'waitingapproval' => 'Please review the submission and take appropriate action.',
            'hrscTicketCompleted' => 'The ticket status is Completed, but the confirmation status is waiting your response. Please review.',
            'hrscConfirmStatusCompleted' => 'The confirmation status is Completed. This ticket was resolved successfully.',
            'hrscConfirmStatusReworked' => 'The confirmation status is Reworked. Please review this ticket again.',
            'newActivity' => 'This Submission has new activity. Please check it.',
            'deadlineTaskReminder' => 'This Submission has a task with an approaching deadline. Please check it.',
            'momTaskSummary' => 'We are proud to inform you regarding this MoM. Please check it.',
            'addPRCreator' => 'We would like to inform you that you have been added as the PR Creator in this submission.',
            'accountInfoAD' => 'This Submission already have new username and password.',
        ];

        return $message;

    }

}