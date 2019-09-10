<?php

namespace Octogun\Client;

use Octogun\Api;

class Repositories extends Api
{
    public $aliases = array(
        'searchRepos'      => 'searchRepositories',
        'repo'             => 'repository',
        'edit'             => 'editRepository',
        'updateRepository' => 'editRepository',
        'update'           => 'editRepository',
        'listRepositories' => 'repositories',
        'listRepos'        => 'repositories',
        'repos'            => 'repositories',
        'createRepo'       => 'createRepository',
        'create'           => 'createRepository',
        'deleteRepo'       => 'deleteRepository',
        'listDeployKeys'   => 'deployKeys',
        'collabs'          => 'collaborators',
        'addCollab'        => 'addCollaborator',
        'removeCollab'     => 'removeCollaborator',
        'repoTeams'        => 'repositoryTeams',
        'teams'            => 'repositoryTeams',
        'contribs'         => 'contributors',
        'getBranch'        => 'branch',
        'repoIssueEvents'  => 'repositoryIssueEvents',
        'repoAssignees'    => 'repositoryAssignees',
    );
    
    /**
     * Legacy repository search.
     * 
     * @see http://developer.github.com/v3/search/#search-repositories
     *
     * @param string $q       Search keyword.
     * @param array  $options Optional options.
     *
     * @return array List of repositories found.
     */
    public function searchRepositories($q, array $options = [])
    {
        $repos = $this->request()->get('legacy/repos/search/' . $q, $options);
        
        return $repos['repositories'];
    }
    
    /**
     * Get a single repository.
     * 
     * @see http://developer.github.com/v3/repos/#get
     *
     * @param string $repo    A GitHub repository.
     * @param array  $options Optional options.
     *
     * @return array Repository information.
     */
    public function repository($repo, array $options = [])
    {
        return $this->request()->get('repos/' . $repo, $options);
    }
    
    /**
     * Edit a repository.
     * 
     * @see http://developer.github.com/v3/repos/#edit
     *
     * @param string $repo    A GitHub repository.
     * @param array  $options Optional options.
     *
     * @return array Repository information.
     */
    public function editRepository($repo, array $options = [])
    {
        return $this->request()->patch('repos/' . $repo, $options);
    }
    
    /**
     * List repositories.
     * 
     * If username is not supplied, repositories for the current
     * authenticated user are returned.
     * 
     * @see http://developer.github.com/v3/repos/#list-your-repositories
     *
     * @param string $username Optional username for which to list repos.
     * @param array  $options  Optional options.
     *
     * @return array List of repositories.
     */
    public function repositories($username = null, array $options = [])
    {
        if (empty($username)) {
            return $this->request()->get('user/repos', $options);
        }
        else {
            return $this->request()->get('user/' . $username . 'repos', $options);
        }
    }
    
    /**
     * List all repositories.
     *  
     * This provides a dump of every repository, in the order that they were
     * created.
     * 
     * @see http://developer.github.com/v3/repos/list-all-repositories
     *
     * @param array $options Optional options.
     *
     * @return array List of repositories.
     */
    public function allRepositories(array $options = [])
    {
        return $this->request()->get('repositories', $options);
    }
    
    /**
     * Star a repository.
     * 
     * @see http://developer.github.com/v3/activity/starring/#star-a-repository
     *
     * @param string $repo    A GitHub repository.
     * @param array  $options Optional options.
     *
     * @return bool True if successfully starred.
     */
    public function star($repo, array $options = [])
    {
        return $this->request()->booleanFromResponse('put', 'user/starred/' . $repo, $options);
    }
    
    /**
     * Unstar a repository.
     * 
     * @see http://developer.github.com/v3/activity/starring/#unstar-a-repository
     *
     * @param string $repo    A GitHub repository.
     * @param array  $options Optional options.
     *
     * @return bool True if successfully unstarred.
     */
    public function unstar($repo, array $options = [])
    {
        return $this->request()->booleanFromResponse('delete', 'user/starred/' . $repo, $options);
    }
    
    /**
     * Watch a repository.
     * 
     * @deprecated Use #star instead.
     * 
     * @see http://developer.github.com/v3/activity/watching/#watch-a-repository-legacy
     *
     * @param string $repo    A GitHub repository.
     * @param array  $options Optional options.
     *
     * @return bool True if successfully watched.
     */
    public function watch($repo, array $options = [])
    {
        return $this->request()->booleanFromResponse('put', 'user/watched/' . $repo, $options);
    }
    
    /**
     * Unwatch a repository.
     * 
     * @deprecated Use #unstar instead.
     * 
     * @see http://developer.github.com/v3/activity/watching/#stop-watching-a-repository-legacy
     *
     * @param string $repo    A GitHub repository.
     * @param array  $options Optional options.
     *
     * @return bool True if successfully unwatched.
     */
    public function unwatch($repo, array $options = [])
    {
        return $this->request()->booleanFromResponse('delete', 'user/watched/' . $repo, $options);
    }
    
    /**
     * Fork a repository.
     * 
     * @see http://developer.github.com/v3/repos/forks/#create-a-fork
     *
     * @param string $repo    A GitHub repository.
     * @param array  $options Optional options.
     *
     * @return array Repository info for the new fork.
     */
    public function fork($repo, array $options = [])
    {
        return $this->request()->post('repos/' . $repo . '/forks', $options);
    }
    
    /**
     * Create a repository for a user or organization.
     * 
     * @see http://developer.github.com/v3/repos/#create
     *
     * @param string $name    Name of the new repo.
     * @param array  $options Optional options.
     *
     * @return array Repository info for the new repository.
     */
    public function createRepository($name, array $options = [])
    {
        $organization = isset($options['organization']) ? $options['organization'] : null;
        
        $options = array_merge(array(
            'name' => $name,
        ), $options);
        
        if (empty($organization)) {
            return $this->request()->post('user/repos', $options);
        }
        else {
            return $this->request()->post('orgs/' . $organization . '/repos', $options);
        }
    }
    
    /**
     * Delete repository.
     * 
     * Note: If OAuth is used, 'delete_repo' scope is required.
     * 
     * @see http://developer.github.com/v3/repos/#delete-a-repository
     *
     * @param string $repo    A GitHub repository.
     * @param array  $options Optional options.
     *
     * @return bool True if successfully deleted.
     */
    public function deleteRepository($repo, array $options = [])
    {
        return $this->request()->booleanFromResponse('delete', 'repo/' . $repo, $options);
    }
    
    /**
     * Hide a public repository.
     *
     * @param string $repo    A GitHub repository.
     * @param array  $options Optional options.
     * 
     * @return array Updated repository info.
     */
    public function setPrivate($repo, array $options = [])
    {
        $options = array_merge(array(
            'private' => true,
        ), $options);
        
        return $this->updateRepository($repo, $options);
    }
    
    /**
     * Unhide a public repository.
     *
     * @param string $repo    A GitHub repository.
     * @param array  $options Optional options.
     * 
     * @return array Updated repository info.
     */
    public function setPublic($repo, array $options = [])
    {
        $options = array_merge(array(
            'private' => false,
        ), $options);
        
        return $this->updateRepository($repo, $options);
    }
    
    /**
     * Get deploy keys on a repo.
     * 
     * Requires authenticated client.
     * 
     * @see http://developer.github.com/v3/repos/keys/#get
     *
     * @param string $repo    A GitHub repository.
     * @param array  $options Optional options.
     *
     * @return array Array of representing deploy keys.
     */
    public function deployKeys($repo, array $options = [])
    {
        return $this->request()->get('repos/' . $repo . '/keys', $options);
    }
    
    /**
     * Add deploy key to a repo.
     * 
     * Requires authenticated client.
     * 
     * @see http://developer.github.com/v3/repos/keys/#create
     *
     * @param string $repo    A GitHub repository.
     * @param string $title   Title reference for the deploy key.
     * @param string $key     Public key.
     * @param array  $options Optional options.
     * 
     * @return array Array representing newly added key.
     */
    public function addDeployKey($repo, $title, $key, array $options = [])
    {
        $options = array_merge(array(
            'title' => $title,
            'key'   => $key,
        ), $options);
        
        return $this->request()->post('repos/' . $repo . '/keys', $options);
    }
    
    /**
     * Remove deploy key from a repo.
     * 
     * Requires authenticated client.
     *
     * @param string $repo    A GitHub repository.
     * @param int    $id      Id of the deploy key to remove.
     * @param array  $options Optional options.
     *
     * @return bool True if key removed, false otherwise.
     */
    public function removeDeployKey($repo, $id, array $options = [])
    {
        return $this->request()->booleanFromResponse('delete', 'repos/' . $repo . '/keys/' . $id, $options);
    }
    
    /**
     * List collaborators.
     * 
     * Requires authenticated client for private repos.
     * 
     * @see http://developer.github.com/v3/repos/collaborators/#list
     *
     * @param string $repo    A GitHub repository.
     * @param array  $options Optional options.
     *
     * @return array Array of representing collaborating users.
     */
    public function collaborators($repo, array $options = [])
    {
        return $this->request()->get('repos/' . $repo . '/collaborators', $options);
    }
    
    /**
     * Add collaborator to repo.
     * 
     * Requires authenticated client.
     * 
     * @see http://developer.github.com/v3/repos/collaborators/#add-collaborator
     *
     * @param string $repo         A GitHub repository.
     * @param string $collaborator Collaborator GitHub username to add.
     * @param array  $options      Optional options.
     *
     * @return bool True if collaborator added, false otherwise.
     */
    public function addCollaborator($repo, $collaborator, array $options = [])
    {
        return $this->request()->booleanFromResponse('put', 'repos/' . $repo . '/collaborators/' . $collaborator, $options);
    }
    
   /**
     * Remove collaborator from repo.
     * 
     * Requires authenticated client.
     * 
     * @see http://developer.github.com/v3/repos/collaborators/#remove-collaborator
     *
     * @param string $repo         A GitHub repository.
     * @param string $collaborator Collaborator GitHub username to remove.
     * @param array  $options      Optional options.
     *
     * @return bool True if collaborator removed, false otherwise.
     */
    public function removeCollaborator($repo, $collaborator, array $options = [])
    {
        return $this->request()->booleanFromResponse('delete', 'repos/' . $repo . '/collaborators/' . $collaborator, $options);
    }
    
    /**
     * List teams for a repo.
     * 
     * Requires authenticated client that is an owner or collaborator of the repo.
     * 
     * @see http://developer.github.com/v3/repos/#list-teams
     *
     * @param string $repo    A GitHub repository.
     * @param array  $options Optional options.
     *
     * @return array Array of representing teams.
     */
    public function repositoryTeams($repo, array $options = [])
    {
        return $this->request()->get('repos/' . $repo . '/teams', $options);
    }
    
    /**
     * List contributors to a repo.
     * 
     * Requires authenticated client for private repos.
     * 
     * @see http://developer.github.com/v3/repos/#list-contributors
     *
     * @param string $repo    A GitHub repository.
     * @param bool   $anon    Set true to include annonymous contributors.
     * @param array  $options Optional options.
     *
     * @return bool Array of representing users.
     */
    public function contributors($repo, $anon = false, array $options = [])
    {
        $options = array_merge(array(
            'anon' => $anon,
        ), $options);
        
        return $this->request()->get('repos/' . $repo . '/contributors', $options);
    }
    
    /**
     * List stargazers of a repo.
     * 
     * Requires authenticated client for private repos.
     * 
     * @see http://developer.github.com/v3/repos/starring/#list-stargazers
     *
     * @param string $repo    A GitHub repository.
     * @param array  $options Optional options.
     *
     * @return array Array of representing users.
     */
    public function stargazers($repo, array $options = [])
    {
        return $this->request()->get('repos/' . $repo . '/stargazers', $options);
    }
    
    /**
     * List watchers of repo.
     * 
     * Requires authenticated client for private repos.
     * 
     * @deprecated Use #stargazers instead
     * 
     * @see http://developer.github.com/v3/repos/watching/#list-watchers
     *
     * @param string $repo    A GitHub repository.
     * @param array  $options Optional options.
     *
     * @return array Array of representing users.
     */
    public function watchers($repo, array $options = [])
    {
        return $this->request()->get('repos/' . $repo . '/watchers', $options);
    }
    
    /**
     * List forks.
     * 
     * Requires authenticated client for private repos.
     * 
     * @see http://developer.github.com/v3/repos/forks/#list-forks
     *
     * @param string $repo    A GitHub repository.
     * @param array  $options Optional options.
     *
     * @return array Array of representing repos.
     */
    public function forks($repo, array $options = [])
    {
        return $this->request()->get('repos/' . $repo . '/forks', $options);
    }
    
    /**
     * List languages of code in the repo.
     * 
     * Requires authenticated client for private repos.
     *
     * @see http://developer.github.com/v3/repos/#list-languages
     *
     * @param string $repo    A GitHub repository.
     * @param array  $options Optional options.
     *
     * @return array Array of representing languages.
     */
    public function languages($repo, array $options = [])
    {
        return $this->request()->get('repos/' . $repo . '/languages', $options);
    }
    
    /**
     * List tags.
     * 
     * Requires authenticated client for private repos.
     *
     * @see http://developer.github.com/v3/repos/#list-tags
     *
     * @param string $repo    A GitHub repository.
     * @param array  $options Optional options.
     *
     * @return array Array of representing tags.
     */
    public function tags($repo, array $options = [])
    {
        return $this->request()->get('repos/' . $repo . '/tags', $options);
    }
    
    /**
     * List branches.
     * 
     * Requires authenticated client for private repos.
     * 
     * @see http://developer.github.com/v3/repos/#list-branches
     *
     * @param string $repo    A GitHub repository.
     * @param array  $options Optional options.
     *
     * @return array Array of representing branches.
     */
    public function branches($repo, array $options = [])
    {
        return $this->request()->get('repos/' . $repo . '/branches', $options);
    }
    
    /**
     * Get a single branch from a repository.
     * 
     * @see http://developer.github.com/v3/repos/#get-branch
     *
     * @param string $repo    A GitHub repository.
     * @param string $branch  Branch name.
     * @param array  $options Optional options.
     *
     * @return array The branch requested, if it exists.
     */
    public function branch($repo, $branch, array $options = [])
    {
        return $this->request()->get('repos/' . $repo . '/branch/' . $branch, $options);
    }
    
    /**
     * List repo hooks.
     * 
     * Requires authenticated client.
     *
     * @see http://developer.github.com/v3/repos/hooks/#list
     *
     * @param string $repo    A GitHub repository.
     * @param array  $options Optional options.
     *
     * @return array Array of representing hooks.
     */
    public function hooks($repo, array $options = [])
    {
        return $this->request()->get('repos/' . $repo . '/hooks', $options);
    }
    
    /**
     * Get single hook.
     * 
     * Requires authenticated client.
     * 
     * @see http://developer.github.com/v3/repos/hooks/#get-single-hook
     *
     * @param string $repo    A GitHub repository.
     * @param int    $id      Id of the hook to get.
     * @param array  $options Optional options.
     *
     * @return array Array representing hook.
     */
    public function hook($repo, $id, array $options = [])
    {
        return $this->request()->get('repos/' . $repo . '/hooks/' . $id, $options);
    }
    
    /**
     * Create a hook.
     * 
     * Requires authenticated client.
     * 
     * @see http://developer.github.com/v3/repos/hooks/#create-a-hook
     *
     * @param string $repo    A GitHub repository.
     * @param string $name    The name of the service that is being called.
     * @param array  $config  An array containing key/value pairs to provide
     *                        settings for this hook.
     * @param array  $options Optional options.
     *
     * @return array Hook info for the new hook.
     */
    public function createHook($repo, $name, array $config, array $options = [])
    {
        $options = array_merge(array(
            'name'   => $name,
            'config' => $config,
            'events' => array('push'),
            'active' => true,
        ), $options);
        
        return $this->request()->post('repos/' . $repo . '/hooks', $options);
    }
    
    /**
     * Edit a hook.
     * 
     * Requires authenticated client.
     * 
     * @see http://developer.github.com/v3/repos/hooks/#edit-a-hook
     *
     * @param string $repo    A GitHub repository.
     * @param int    $id      Id of the hook being updated.
     * @param string $name    The name of the service that is being called.
     * @param array  $config  An array containing key/value pairs to provide
     *                        settings for this hook.
     * @param array  $options Optional options.
     *
     * @return array Hook info for the updated hook.
     */
    public function editHook($repo, $id, $name, array $config, array $options = [])
    {
        $options = array_merge(array(
            'name'   => $name,
            'config' => $config,
            'events' => array('push'),
            'active' => true,
        ), $options);
        
        return $this->request()->patch('repos/' . $repo . '/hooks/' . $id, $options);
    }
    
    /**
     * Delete hook.
     * 
     * Requires authenticated client.
     * 
     * @see http://developer.github.com/v3/repos/hooks/#test-a-hook
     *
     * @param string $repo    A GitHub repository.
     * @param int    $id      Id of the hook to remove.
     * @param array  $options Optional options.
     *
     * @return bool True if hook removed, false otherwise.
     */
    public function removeHook($repo, $id, array $options = [])
    {
        return $this->request()->booleanFromResponse('delete', 'repos/' . $repo . '/hooks/' . $id, $options);
    }
    
    /**
     * Test hook.
     * 
     * Requires authenticated client.
     * 
     * @see http://developer.github.com/v3/issues/events/#list-events-for-a-repository
     *
     * @param string $repo    A GitHub repository.
     * @param int    $id      Id of the hook to test.
     * @param array  $options Optional options.
     *
     * @return null
     */
    public function testHook($repo, $id, array $options = [])
    {
        return $this->request()->booleanFromResponse('delete', 'repos/' . $repo . '/hooks/' . $id . '/tests', $options);
    }
    
    /**
     * Get all Issue Events for a given Repository.
     * 
     * @see http://developer.github.com/v3/issues/events/#list-events-for-a-repository
     *
     * @param string $repo    A GitHub repository.
     * @param array  $options Optional options.
     *
     * @return array Array of all Issue Events for this Repository.
     */
    public function repositoryIssueEvents($repo, array $options = [])
    {
        return $this->request()->get('repos/' . $repo . '/issues/events', $options);
    }
    
    /**
     * List users available for assigning to issues.
     * 
     * Requires authenticated client for private repos.
     * 
     * @see http://developer.github.com/v3/issues/assignees/#list-assignees
     *
     * @param string $repo    A GitHub repository.
     * @param array  $options Optional options.
     *
     * @return array Array of representing users.
     */
    public function repositoryAssignees($repo, array $options = [])
    {
        return $this->request()->get('repos/' . $repo . '/assignees', $options);
    }
    
    /**
     * Check to see if a particular user is an assignee for a repository.
     * 
     * @see http://developer.github.com/v3/issues/assignees/#check-assignee
     *
     * @param string $repo     A GitHub repository.
     * @param string $assignee User login to check
     * @param array  $options  Optional options.
     *
     * @return bool True if assignable on project, false otherwise.
     */
    public function checkAssignee($repo, $assignee, array $options = [])
    {
        return $this->request()->booleanFromResponse('get', 'repos/' . $repo . '/assignees/' . $assignee, $options);
    }
    
    /**
     * List watchers subscribing to notifications for a repo.
     * 
     * @see http://developer.github.com/v3/activity/watching/#list-watchers
     *
     * @param string $repo    A GitHub repository.
     * @param array  $options Optional options.
     *
     * @return array Array of users watching.
     */
    public function subscribers($repo, array $options = [])
    {
        return $this->request()->get('repos/' . $repo . '/subscribers', $options);
    }
    
    /**
     * Get a repository subscription.
     * 
     * @see http://developer.github.com/v3/activity/watching/#get-a-repository-subscription
     *
     * @param string $repo    A GitHub repository.
     * @param array  $options Optional options.
     *
     * @return array Repository subscription.
     */
    public function subscription($repo, array $options = [])
    {
        return $this->request()->get('repos/' . $repo . '/subscription', $options);
    }
    
    /**
     * Update repository subscription.
     * 
     * @see http://developer.github.com/v3/activity/watching/#set-a-repository-subscription
     *
     * @param string $repo    A GitHub repository.
     * @param array  $options Optional options.
     *
     * @return array Updated repository subscription.
     */
    public function updateSubscription($repo, array $options = [])
    {
        return $this->request()->put('repos/' . $repo . '/subscription', $options);
    }
    
    /**
     * Delete a repository subscription.
     * 
     * @see http://developer.github.com/v3/activity/watching/#delete-a-repository-subscription
     *
     * @param string $repo    A GitHub repository.
     * @param array  $options Optional options.
     *
     * @return bool True if subscription deleted, false otherwise.
     */
    public function deleteSubscription($repo, array $options = [])
    {
        return $this->request()->booleanFromResponse('delete', 'repos/' . $repo . '/subscription', $options);
    }
}
