<?php
namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
		
		// 清空原权限配置
		$auth->removeAll();
		
		/* －－－－－－－－－－－－－创建权限开始－－－－－－－－－－－ */
		
		// user增删改查
		$createUser = $auth->createPermission('createUser');
        $createUser->description = 'Create a user';
        $auth->add($createUser);
		
		$viewUser = $auth->createPermission('viewUser');
        $viewUser->description = 'View a user';
        $auth->add($viewUser);
		
		$updateUser = $auth->createPermission('updateUser');
        $updateUser->description = 'Update a user';
        $auth->add($updateUser);
		
		$deleteUser = $auth->createPermission('deleteUser');
        $deleteUser->description = 'Delete a user';
        $auth->add($deleteUser);
		
		// issue增删改查
		$createIssue = $auth->createPermission('createIssue');
        $createIssue->description = 'Create a issue';
        $auth->add($createIssue);
		
		$viewIssue = $auth->createPermission('viewIssue');
        $viewIssue->description = 'View a issue';
        $auth->add($viewIssue);
		
		$updateIssue = $auth->createPermission('updateIssue');
        $updateIssue->description = 'Update a issue';
        $auth->add($updateIssue);
		
		$deleteIssue = $auth->createPermission('deleteIssue');
        $deleteIssue->description = 'Delete a issue';
        $auth->add($deleteIssue);
		
		// project增删改查
		$createProject = $auth->createPermission('createProject');
        $createProject->description = 'Create a project';
        $auth->add($createProject);
		
		$viewProject = $auth->createPermission('viewProject');
        $viewProject->description = 'View a project';
        $auth->add($viewProject);
		
		$updateProject = $auth->createPermission('updateProject');
        $updateProject->description = 'Update a project';
        $auth->add($updateProject);
		
		$deleteProject = $auth->createPermission('deleteProject');
        $deleteProject->description = 'Delete a project';
        $auth->add($deleteProject);
		
		/* －－－－－－－－－－－－－创建权限结束－－－－－－－－－－－ */
		
		
		/* －－－－－－－－－－－－－创建角色开始－－－－－－－－－－－ */
		
		// reader
		$reader = $auth->createRole('reader');
        $auth->add($reader);
		// member
		$member = $auth->createRole('member');
        $auth->add($member);
		// owner
		 $owner = $auth->createRole('owner');
        $auth->add($owner);
		
		/* －－－－－－－－－－－－－创建角色结束－－－－－－－－－－－ */
		
		
		/* －－－－－－－－－－－－－分配权限开始－－－－－－－－－－－ */
		
		// reader
		$auth->addChild($reader, $viewProject);
		$auth->addChild($reader, $viewIssue);
		$auth->addChild($reader, $viewUser);
		
		// member
		$auth->addChild($member, $reader); // member享有reader的所有权限
		$auth->addChild($reader, $createIssue);
		$auth->addChild($reader, $updateIssue);
		$auth->addChild($reader, $deleteIssue);
		
		// owner
		// $auth->addChild($owner, $reader); // owner享有member的所有权限
		$auth->addChild($owner, $member); // owner享有member的所有权限
		$auth->addChild($reader, $createUser);
		$auth->addChild($reader, $updateUser);
		$auth->addChild($reader, $deleteUser);
		$auth->addChild($reader, $createProject);
		$auth->addChild($reader, $updateProject);
		$auth->addChild($reader, $deleteProject);
		/* －－－－－－－－－－－－－分配权限结束－－－－－－－－－－－ */
		
		
		

        /* // add "createPost" permission
        $createPost = $auth->createPermission('createPost');
        $createPost->description = 'Create a post';
        $auth->add($createPost);

        // add "updatePost" permission
        $updatePost = $auth->createPermission('updatePost');
        $updatePost->description = 'Update post';
        $auth->add($updatePost);

        // add "author" role and give this role the "createPost" permission
        $author = $auth->createRole('author');
        $auth->add($author);
        $auth->addChild($author, $createPost);

        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $updatePost);
        $auth->addChild($admin, $author);

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        $auth->assign($author, 2);
        $auth->assign($admin, 1); */
    }
}