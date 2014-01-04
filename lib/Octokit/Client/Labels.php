<?php

namespace Octokit\Client;

use Octokit\Api;

class Labels extends Api
{
    /**
     * List available labels for a repository.
     * 
     * @see http://developer.github.com/v3/issues/labels/#list-all-labels-for-this-repository
     *
     * @param string $repo    A GitHub repository.
     * @param array  $options Optional options.
     *
     * @return array A list of the labels across the repository.
     */
    public function labels($repo, array $options = array())
    {
        return $this->request()->get('repos/' . $repo . '/labels', $options);
    }
    
    /**
     * Get single label for a repository.
     * 
     * @see http://developer.github.com/v3/issues/labels/#get-a-single-label
     *
     * @param string $repo    A GitHub repository.
     * @param string $name    Name of the label.
     * @param array  $options Optional options.
     *
     * @return array A single label from the repository.
     */
    public function label($repo, $name, array $options = array())
    {
        return $this->request()->get('repos/' . $repo . '/labels/' . urlencode($name), $options);
    }
    
    /**
     * Add a label to a repository.
     * 
     * @see http://developer.github.com/v3/issues/labels/#create-a-label
     *
     * @param string $repo    A GitHub repository.
     * @param string $label   A new label.
     * @param string $color   A color, in hex, without the leading #.
     * @param array  $options Optional options.
     * 
     * @return array An array of the new label.
     */
    public function addLabel($repo, $label, $color = 'ffffff', array $options = array())
    {
        $options = array_merge(array(
            'name'  => $label,
            'color' => $color,
        ), $options);
        
        return $this->request()->post('repos/' . $repo . '/labels', $options);
    }
    
    /**
     * Update a label.
     * 
     * @see http://developer.github.com/v3/issues/labels/#update-a-label
     *
     * @param string $repo    A GitHub repository.
     * @param string $label   The name of the label which will be updated.
     * @param array  $options Optional options.
     *
     * @return array An array of the updated label.
     */
    public function updateLabel($repo, $label, array $options = array())
    {
        return $this->request()->patch('repos/' . $repo . '/labels/' . urlencode($label), $options);
    }
    
    /**
     * Delete a label from a repository.
     * 
     * This deletes the label from the repository, and removes it from all issues.
     * 
     * @see http://developer.github.com/v3/issues/labels/#delete-a-label
     *
     * @param string $repo    A GitHub repository.
     * @param string $label   String name of the label.
     * @param array  $options Optional options.
     *
     * @return bool Success.
     */
    public function deleteLabel($repo, $label, array $options = array())
    {
        return $this->request()->booleanFromResponse('delete', 'repos/' . $repo . '/labels/' . urlencode($label), $options);
    }
    
    /**
     * Remove a label from an Issue.
     * 
     * This removes the label from the Issue.
     * 
     * @see http://developer.github.com/v3/issues/labels/#remove-a-label-from-an-issue
     *
     * @param string $repo    A GitHub repository.
     * @param string $number  Number ID of the issue.
     * @param string $label   String name of the label.
     * @param array  $options Optional options.
     *
     * @return array A list of the labels currently on the issue.
     */
    public function removeLabel($repo, $number, $label, array $options = array())
    {
        return $this->request()->delete('repos/' . $repo . '/issues/' . $number . '/labels/' . urlencode($label), $options);
    }
    
    /**
     * Remove all label from an Issue.
     * 
     * This removes the label from the Issue.
     * 
     * @see http://developer.github.com/v3/issues/labels/#remove-all-labels-from-an-issue
     *
     * @param string $repo    A GitHub repository.
     * @param string $number  Number ID of the issue.
     * @param array  $options Optional options.
     *
     * @return bool Success of operation.
     */
    public function removeAllLabels($repo, $number, array $options = array())
    {
        return $this->request()->booleanFromResponse('delete', 'repos/' . $repo . '/issues/' . $number . '/labels', $options);
    }
    
    /**
     * List labels for a given issue.
     * 
     * @see http://developer.github.com/v3/issues/labels/#list-labels-on-an-issue
     *
     * @param string $repo    A GitHub repository.
     * @param string $number  Number ID of the issue.
     * @param array  $options Optional options.
     *
     * @return array A list of the labels currently on the issue.
     */
    public function labelsForIssue($repo, $number, array $options = array())
    {
        return $this->request()->get('repos/' . $repo . '/issues/' . $number . '/labels', $options);
    }
    
    /**
     * Add label(s) to an Issue.
     * 
     * @see http://developer.github.com/v3/issues/labels/#add-labels-to-an-issue
     *
     * @param string $repo   A GitHub repository.
     * @param string $number Number ID of the issue.
     * @param array  $labels An array of labels to apply to this Issue.
     * 
     * @return array A list of the labels currently on the issue.
     */
    public function addLabelsToAnIssue($repo, $number, $labels)
    {
        return $this->request()->post('repos/' . $repo . '/issues/' . $number . '/labels', $labels);
    }
    
    /**
     * Replace all labels on an Issue.
     * 
     * @see http://developer.github.com/v3/issues/labels/#replace-all-labels-for-an-issue
     *
     * @param string $repo    A GitHub repository.
     * @param string $number  Number ID of the issue.
     * @param array  $labels  An array of labels to use as replacement.
     * @param array  $options Optional options.
     *
     * @return array A list of the labels currently on the issue.
     */
    public function replaceAllLabels($repo, $number, $labels, array $options = array())
    {
        return $this->request()->put('repos/' . $repo . '/issues/' . $number . '/labels', $labels);
    }
    
    /**
     * Get labels for every issue in a milestone.
     * 
     * @see http://developer.github.com/v3/issues/labels/#get-labels-for-every-issue-in-a-milestone
     *
     * @param string $repo    A GitHub repository.
     * @param string $number  Number ID of the milestone.
     * @param array  $options Optional options.
     *
     * @return array A list of the labels across the milestone.
     */
    public function labelsForMilestone($repo, $number, array $options = array())
    {
        return $this->request()->get('repos/' . $repo . '/milestones/' . $number . '/labels', $options);
    }
}
