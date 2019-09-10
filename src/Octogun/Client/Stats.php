<?php

namespace Octogun\Client;

use Octogun\Api;

class Stats extends Api
{
    public $aliases = array(
        'contributorStats' => 'contributorsStats',
        'punchCard'        => 'punchCardStats',
    );
    
    /**
     * Get contributors list with additions, deletions, and commit counts.
     * 
     * @see http://developer.github.com/v3/repos/statistics/#get-contributors-list-with-additions-deletions-and-commit-counts
     * 
     * @param string $repo A GitHub repository.
     * 
     * @return array Array of contributor stats.
     */
    public function contributorsStats($repo)
    {
        return $this->getStats($repo, 'contributors');
    }
    
    /**
     * Get the last year of commit activity data.
     * 
     * @see http://developer.github.com/v3/repos/statistics/#get-the-number-of-additions-and-deletions-per-week
     * 
     * @param string $repo A GitHub repository.
     * 
     * @return array The last year of commit activity grouped by
     *               week. The days array is a group of commits per day, starting on Sunday.
     */
    public function commitActivityStats($repo)
    {
        return $this->getStats($repo, 'commit_activity');
    }
    
    /**
     * Get the number of additions and deletions per week.
     * 
     * @see http://developer.github.com/v3/repos/statistics/#get-the-number-of-additions-and-deletions-per-week
     * 
     * @param string $repo A GitHub repository.
     * 
     * @return array Weekly aggregate of the number of additions
     *               and deletions pushed to a repository.
     */
    public function codeFrequencyStats($repo)
    {
        return $this->getStats($repo, 'code_frequency');
    }
    
    /**
     * Get the weekly commit count for the repo owner and everyone else.
     * 
     * @see http://developer.github.com/v3/repos/statistics/#get-the-weekly-commit-count-for-the-repo-owner-and-everyone-else
     * 
     * @param string $repo A GitHub repository.
     * 
     * @return array Total commit counts for the owner and total commit
     *               counts in all. all is everyone combined, including the owner in the last
     *               52 weeks. If you’d like to get the commit counts for non-owners, you can
     *               subtract all from owner.
     */
    public function participationStats($repo)
    {
        return $this->getStats($repo, 'participation');
    }
    
    /**
     * Get the number of commits per hour in each day.
     * 
     * @see http://developer.github.com/v3/repos/statistics/#get-the-number-of-commits-per-hour-in-each-day
     * 
     * @param string $repo A GitHub repository.
     * 
     * @return array Arrays containing the day number, hour number, and
     *               number of commits.
     */
    public function punchCardStats($repo)
    {
        return $this->getStats($repo, 'punch_card');
    }
    
    /**
     * Get stats for a repository.
     *
     * @param string $repo    A GitHub repository.
     * @param strring $metric The metrics you are looking for.
     *
     * @return array Magical unicorn stats.
     */
    protected function getStats($repo, $metric)
    {
        return $this->request()->get('repos/' . $repo . '/stats/' . $metric);
    }
}
