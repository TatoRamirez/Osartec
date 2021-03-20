<?php
/**
 * @package SiteTree
 * @copyright Copyright 2020 Luigi Cavalieri.
 * @license https://opensource.org/licenses/GPL-3.0 GPL v3.0
 *
 *
 *
 * @since 1.4
 */
interface SiteTreePageViewDelegateProtocol {
    /**
     * @since 2.0
     * @param object $pageView
     */
    public function pageViewWillDisplayForm( $pageView );

    /**
     * @since 1.4
     *
     * @param object $field
     * @param string $section_id
     * @return mixed
     */
    public function pageViewFieldValue( $field, $section_id );

    /**
     * @since 2.0
     *
     * @param object $pageView
     * @return string
     */
    public function pageViewFormAction( $pageView );
}


/**
 * @since 1.4
 */
interface SiteTreeDashboardDelegateProtocol {
    /**
     * @since 3.2
     *
     * @param object $dashboard
     * @param string $form_id
     * @return string
     */
    public function dashboardWillRenderToolbarButtons( $dashboard, $form_id );

    /**
     * @since 3.2
     *
     * @param object $dashboard
     * @param string $form_id
     * @return bool
     */
    public function dashboardCanRenderStats( $dashboard, $form_id );

    /**
     * @since 3.0
     * @return string
     */
    public function dashboardDidDisplayForms();
}