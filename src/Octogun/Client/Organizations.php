<?php

namespace Octogun\Client;

use Octogun\Api;

class Organizations extends Api
{
    public $aliases = array(
        'org'                   => 'organization',
        'updateOrg'             => 'updateOrganization',
        'listOrganizations'     => 'organizations',
        'listOrgs'              => 'organizations',
        'orgs'                  => 'organizations',
        'orgRepositories'       => 'organizationRepositories',
        'orgRepos'              => 'organizationRepositories',
        'organizationMembers'   => 'organizationMembers',
        'orgMember'             => 'organizationMember',
        'orgPublicMember'       => 'organizationPublicMember',
        'orgTeams'              => 'organizationTeams',
        'teamRepos'             => 'teamRepositories',
        'removeTeamRepo'        => 'removeTeamRepository',
        'removeOrgMember'       => 'removeOrganizationMember',
        'unpublicizeMembership' => 'unpublicizeMembership',
    );
    
    /**
     * Get an organization.
     * 
     * @see http://developer.github.com/v3/orgs/#get-an-organization
     *
     * @param string $org     Organization GitHub username.
     * @param array  $options Optional options.
     *
     * @return array Array representing GitHub organization.
     */
    public function organization($org, array $options = [])
    {
        return $this->request()->get('orgs/' . $org, $options);
    }
    
    /**
     * Update an organization.
     * 
     * Requires authenticated client with proper organization permissions.
     * 
     * @see http://developer.github.com/v3/orgs/#edit-an-organization
     *
     * @param string $org     Organization GitHub username.
     * @param array  $values  The updated organization attributes.
     * @param array  $options Optional options.
     *
     * @return array Array representing GitHub organization.
     */
    public function updateOrganization($org, $values, array $options = [])
    {
        $options = array_merge(array(
            'organization' => $values,
        ));
        
        return $this->request()->patch('orgs/' . $org, $options);
    }
    
    /**
     * Get organizations for a user.
     * 
     * Nonauthenticated calls to this method will return organizations that
     * the user is a public member.
     * 
     * Use an authenicated client to get both public and private organizations
     * for a user.
     * 
     * @see http://developer.github.com/v3/orgs/#list-user-organizations
     *
     * @param string $user    Username of the user to get list of organizations.
     * @param array  $options Optional options.
     *
     * @return array Array of representing organizations.
     */
    public function organizations($user = null, array $options = [])
    {
        if (!empty($user)) {
            return $this->request()->get('users/' . $user . '/orgs');
        }
        else {
            return $this->request()->get('user/orgs');
        }
    }
    
    /**
     * List organization repositories.
     * 
     * Public repositories are available without authentication. Private repos
     * require authenticated organization member.
     * 
     * @see http://developer.github.com/v3/repos/#list-organization-repositories
     *
     * @param string $org     Organization handle for which to list repos.
     * @param array  $options Optional options.
     *
     * @return array List of repositories.
     */
    public function organizationRepositories($org, array $options = [])
    {
        return $this->request()->get('orgs/' . $org . '/repos', $options);
    }
    
    /**
     * Get organization members.
     * 
     * Public members of the organization are returned by default. An
     * authenticated client that is a member of the GitHub organization
     * is required to get private members.
     * 
     * @see http://developer.github.com/v3/orgs/members/#list-members
     *
     * @param string $org     Organization GitHub username.
     * @param array  $options Optional options.
     *
     * @return array Array of representing users.
     */
    public function organizationMembers($org, array $options = [])
    {
        return $this->request()->get('orgs/' . $org . '/members', $options);
    }
    
    /**
     * Check if a user is a member of an organization.
     * 
     * @see http://developer.github.com/v3/orgs/members/#check-membership
     *
     * @param string $org     Organization GitHub username.
     * @param string $user    GitHub username of the user to check.
     * @param array  $options Optional options.
     *
     * @return bool Is a member?
     */
    public function organizationMember($org, $user, array $options = [])
    {
        return $this->request()->booleanFromResponse('get', 'orgs/' . $org . '/members/' . $user, $options);
    }
    
    /**
     * Check if a user is a public member of an organization.
     * 
     * @see http://developer.github.com/v3/orgs/members/#check-public-membership
     *
     * @param string $org     Organization GitHub username.
     * @param string $user    GitHub username of the user to check.
     * @param array  $options Optional options.
     *
     * @return bool Is a public member?
     */
    public function organizationPublicMember($org, $user, array $options = [])
    {
        return $this->request()->booleanFromResponse('get', 'orgs/' . $org . '/public_members/' . $user, $options);
    }
    
    /**
     * List teams.
     * 
     * Requires authenticated organization member.
     * 
     * @see http://developer.github.com/v3/orgs/teams/#list-teams
     *
     * @param string $org     Organization GitHub username.
     * @param array  $options Optional options.
     *
     * @return array Array of representing teams.
     */
    public function organizationTeams($org, array $options = [])
    {
        return $this->request()->get('orgs/' . $org . '/teams', $options);
    }
    
    /**
     * Create team.
     * 
     * Requires authenticated organization owner.
     * 
     * @see http://developer.github.com/v3/orgs/teams/#create-team
     *
     * @param string $org     Organization GitHub username.
     * @param array  $options Optional options.
     *
     * @return array Array representing new team.
     */
    public function createTeam($org, array $options = [])
    {
        return $this->request()->post('orgs/' . $org . '/teams', $options);
    }
    
    /**
     * Get team.
     * 
     * Requires authenticated organization member.
     * 
     * @see http://developer.github.com/v3/orgs/teams/#get-team
     *
     * @param int   $team_id Team id.
     * @param array $options Optional options.
     *
     * @return array Array representing team.
     */
    public function team($team_id, array $options = [])
    {
        return $this->request()->get('teams/' . $team_id, $options);
    }
    
    /**
     * Update team.
     * 
     * Requires authenticated organization owner.
     * 
     * @see http://developer.github.com/v3/orgs/teams/#edit-team
     *
     * @param int   $team_id Team id.
     * @param array $options Optional options.
     *
     * @return array Array representing updated team.
     */
    public function updateTeam($team_id, array $options = [])
    {
        return $this->request()->patch('teams/' . $team_id, $options);
    }
    
    /**
     * Delete team.
     * 
     * Requires authenticated organization owner.
     * 
     * @see http://developer.github.com/v3/orgs/teams/#delete-team
     *
     * @param int   $team_id Team id.
     * @param array $options Optional options.
     *
     * @return bool True if deletion successful, false otherwise.
     */
    public function deleteTeam($team_id, array $options = [])
    {
        return $this->request()->booleanFromResponse('delete', 'teams/' . $team_id, $options);
    }
    
    /**
     * List team members.
     * 
     * Requires authenticated organization member.
     * 
     * @see http://developer.github.com/v3/orgs/teams/#list-team-members
     *
     * @param int   $team_id Team id.
     * @param array $options Optional options.
     *
     * @return array Array of representing users.
     */
    public function teamMembers($team_id, array $options = [])
    {
        return $this->request()->get('teams/' . $team_id . '/members', $options);
    }
    
    /**
     * Add team member.
     * 
     * Requires authenticated organization owner or member with team 
     * `admin` permission.
     * 
     * @see http://developer.github.com/v3/orgs/teams/#add-team-member
     *
     * @param int    $team_id Team id.
     * @param string $user    GitHub username of new team member.
     * @param array  $options Optional options.
     * 
     * @return bool True on successful addition, false otherwise.
     */
    public function addTeamMember($team_id, $user, array $options = [])
    {
        $options = array_merge(array(
            'name' => $user,
        ));
        
        return $this->request()->booleanFromResponse('put', 'teams/' . $team_id . '/members/' . $user, $options);
    }
    
    /**
     * Remove team member.
     * 
     * Requires authenticated organization owner or member with team 
     * `admin` permission.
     * 
     * @see http://developer.github.com/v3/orgs/teams/#remove-team-member
     *
     * @param int    $team_id Team id.
     * @param string $user    GitHub username of the user to boot.
     * @param array  $options Optional options.
     *
     * @return bool True if user removed, false otherwise.
     */
    public function removeTeamMember($team_id, $user, array $options = [])
    {
        return $this->request()->booleanFromResponse('delete', 'teams/' . $team_id . '/members/' . $user, $options);
    }
    
    /**
     * Check if a user is a member of a team.
     * 
     * Use this to check if another user is a member of a team that
     * you are a member.
     * 
     * @see http://developer.github.com/v3/orgs/teams/#get-team-member
     *
     * @param int    $team_id Team id.
     * @param string $user    GitHub username of the user to check.
     * @param array  $options Optional options.
     *
     * @return bool Is a member?
     */
    public function teamMember($team_id, $user, array $options = [])
    {
        return $this->request()->booleanFromResponse('get', 'teams/' . $team_id . '/members/' . $user, $options);
    }
    
    /**
     * List team repositories.
     * 
     * Requires authenticated organization member.
     * 
     * @see http://developer.github.com/v3/orgs/teams/#list-team-repos
     *
     * @param int   $team_id Team id.
     * @param array $options Optional options.
     *
     * @return array Array of representing repositories.
     */
    public function teamRepositories($team_id, array $options = [])
    {
        return $this->request()->get('teams/' . $team_id . '/repos', $options);
    }
    
    /**
     * Add team repository.
     * 
     * Requires authenticated user to be an owner of the organization that the
     * team is associated with. Also, the repo must be owned by the
     * organization, or a direct form of a repo owned by the organization.
     * 
     * @see http://developer.github.com/v3/orgs/teams/#add-team-repo
     *
     * @param int    $team_id Team id.
     * @param string $repo    A GitHub repository.
     * @param array  $options Optional options.
     * 
     * @return bool True if successful, false otherwise.
     */
    public function addTeamRepository($team_id, $repo, array $options = [])
    {
        $options = array_merge(array(
            'name' => $repo,
        ));
        
        return $this->request()->booleanFromResponse('put', 'teams/' . $team_id . '/repos/' . $repo, $options);
    }
    
    /**
     * Remove team repository.
     * 
     * Removes repository from team. Does not delete the repository.
     * 
     * Requires authenticated organization owner.
     * 
     * @see http://developer.github.com/v3/orgs/teams/#remove-team-repo
     *
     * @param int    $team_id Team id.
     * @param string $repo    A GitHub repository.
     * @param array  $options Optional options.
     *
     * @return bool Return true if repo removed from team, false otherwise.
     */
    public function removeTeamRepository($team_id, $repo, array $options = [])
    {
        return $this->request()->booleanFromResponse('delete', 'teams/' . $team_id . '/repos/' . $repo, $options);
    }
    
    /**
     * Remove organization member.
     * 
     * Requires authenticated organization owner or member with team `admin` access.
     * 
     * @see http://developer.github.com/v3/orgs/teams/#remove-team-member
     *
     * @param string $org     Organization GitHub username.
     * @param string $user    GitHub username of user to remove.
     * @param array  $options Optional options.
     *
     * @return bool True if removal is successful, false otherwise.
     */
    public function removeOrganizationMember($org, $user, array $options = [])
    {
        return $this->request()->booleanFromResponse('delete', 'orgs/' . $org . '/members/' . $user, $options);
    }
    
    /**
     * Publicize a user's membership of an organization.
     * 
     * Requires authenticated organization owner.
     * 
     * @see http://developer.github.com/v3/orgs/members/#publicize-a-users-membership
     *
     * @param string $org     Organization GitHub username.
     * @param string $user    GitHub username of user to publicize.
     * @param array  $options Optional options.
     *
     * @return bool True if publicization successful, false otherwise.
     */
    public function publicizeMembership($org, $user, array $options = [])
    {
        return $this->request()->booleanFromResponse('put', 'orgs/' . $org . '/public_members/' . $user, $options);
    }
    
    /**
     * Conceal a user's membership of an organization.
     * 
     * Requires authenticated organization owner.
     * 
     * @see http://developer.github.com/v3/orgs/members/#conceal-a-users-membership
     *
     * @param string $org     Organization GitHub username.
     * @param string $user    GitHub username of user to unpublicize.
     * @param array  $options Optional options.
     *
     * @return bool True of unpublicization successful, false otherwise.
     */
    public function unpublicizeMembership($org, $user, array $options = [])
    {
        return $this->request()->booleanFromResponse('delete', 'orgs/' . $org . '/public_members/' . $user, $options);
    }
}
