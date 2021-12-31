<?php return array (
  0 => 
  array (
    'GET' => 
    array (
      '/addon' => 'addon',
      '/addon/linkers' => 'addon_linkers',
      '/hook_events' => 'hook_events',
      '/repositories' => 'repositories',
      '/snippets' => 'snippets',
      '/teams' => 'teams',
      '/user' => 'user',
      '/user/emails' => 'user_emails',
      '/user/permissions/repositories' => 'user_permissions_repositories',
      '/user/permissions/teams' => 'user_permissions_teams',
      '/user/permissions/workspaces' => 'user_permissions_workspaces',
      '/workspaces' => 'workspaces',
    ),
  ),
  1 => 
  array (
    'GET' => 
    array (
      0 => 
      array (
        'regex' => '~^(?|/addon/linkers/([^/]+)(*MARK:a)|/addon/linkers/([^/]+)/values(*MARK:b)|/addon/linkers/([^/]+)/values/([^/]+)(*MARK:c)|/hook_events/([^/]+)(*MARK:d)|/pullrequests/([^/]+)(*MARK:e)|/repositories/([^/]+)(*MARK:f)|/repositories/([^/]+)/([^/]+)(*MARK:g)|/repositories/([^/]+)/([^/]+)/branch\\-restrictions(*MARK:h)|/repositories/([^/]+)/([^/]+)/branch\\-restrictions/([^/]+)(*MARK:i)|/repositories/([^/]+)/([^/]+)/branching\\-model(*MARK:j)|/repositories/([^/]+)/([^/]+)/branching\\-model/settings(*MARK:k)|/repositories/([^/]+)/([^/]+)/commit/([^/]+)(*MARK:l)|/repositories/([^/]+)/([^/]+)/commit/([^/]+)/approve(*MARK:m)|/repositories/([^/]+)/([^/]+)/commit/([^/]+)/comments(*MARK:n)|/repositories/([^/]+)/([^/]+)/commit/([^/]+)/comments/([^/]+)(*MARK:o)|/repositories/([^/]+)/([^/]+)/commit/([^/]+)/properties/([^/]+)/([^/]+)(*MARK:p)|/repositories/([^/]+)/([^/]+)/commit/([^/]+)/pullrequests(*MARK:q)|/repositories/([^/]+)/([^/]+)/commit/([^/]+)/reports(*MARK:r)|/repositories/([^/]+)/([^/]+)/commit/([^/]+)/reports/([^/]+)(*MARK:s)|/repositories/([^/]+)/([^/]+)/commit/([^/]+)/reports/([^/]+)/annotations(*MARK:t)|/repositories/([^/]+)/([^/]+)/commit/([^/]+)/reports/([^/]+)/annotations/([^/]+)(*MARK:u)|/repositories/([^/]+)/([^/]+)/commit/([^/]+)/statuses(*MARK:v)|/repositories/([^/]+)/([^/]+)/commit/([^/]+)/statuses/build(*MARK:w)|/repositories/([^/]+)/([^/]+)/commit/([^/]+)/statuses/build/([^/]+)(*MARK:x)|/repositories/([^/]+)/([^/]+)/commits(*MARK:y)|/repositories/([^/]+)/([^/]+)/commits/([^/]+)(*MARK:z)|/repositories/([^/]+)/([^/]+)/components(*MARK:aa)|/repositories/([^/]+)/([^/]+)/components/([^/]+)(*MARK:ab))$~',
        'routeMap' => 
        array (
          'a' => 
          array (
            0 => 'addon_linkers_linker_key',
            1 => 
            array (
              'linker_key' => 'linker_key',
            ),
          ),
          'b' => 
          array (
            0 => 'addon_linkers_linker_key_values',
            1 => 
            array (
              'linker_key' => 'linker_key',
            ),
          ),
          'c' => 
          array (
            0 => 'addon_linkers_linker_key_values_value_id',
            1 => 
            array (
              'linker_key' => 'linker_key',
              'value_id' => 'value_id',
            ),
          ),
          'd' => 
          array (
            0 => 'hook_events_subject_type',
            1 => 
            array (
              'subject_type' => 'subject_type',
            ),
          ),
          'e' => 
          array (
            0 => 'pullrequests_selected_user',
            1 => 
            array (
              'selected_user' => 'selected_user',
            ),
          ),
          'f' => 
          array (
            0 => 'repositories_workspace',
            1 => 
            array (
              'workspace' => 'workspace',
            ),
          ),
          'g' => 
          array (
            0 => 'repositories_workspace_repo_slug',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
            ),
          ),
          'h' => 
          array (
            0 => 'repositories_workspace_repo_slug_branch_restrictions',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
            ),
          ),
          'i' => 
          array (
            0 => 'repositories_workspace_repo_slug_branch_restrictions_id',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'id' => 'id',
            ),
          ),
          'j' => 
          array (
            0 => 'repositories_workspace_repo_slug_branching_model',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
            ),
          ),
          'k' => 
          array (
            0 => 'repositories_workspace_repo_slug_branching_model_settings',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
            ),
          ),
          'l' => 
          array (
            0 => 'repositories_workspace_repo_slug_commit_commit',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'commit' => 'commit',
            ),
          ),
          'm' => 
          array (
            0 => 'repositories_workspace_repo_slug_commit_commit_approve',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'commit' => 'commit',
            ),
          ),
          'n' => 
          array (
            0 => 'repositories_workspace_repo_slug_commit_commit_comments',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'commit' => 'commit',
            ),
          ),
          'o' => 
          array (
            0 => 'repositories_workspace_repo_slug_commit_commit_comments_comment_id',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'commit' => 'commit',
              'comment_id' => 'comment_id',
            ),
          ),
          'p' => 
          array (
            0 => 'repositories_workspace_repo_slug_commit_commit_properties_app_key_property_name',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'commit' => 'commit',
              'app_key' => 'app_key',
              'property_name' => 'property_name',
            ),
          ),
          'q' => 
          array (
            0 => 'repositories_workspace_repo_slug_commit_commit_pullrequests',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'commit' => 'commit',
            ),
          ),
          'r' => 
          array (
            0 => 'repositories_workspace_repo_slug_commit_commit_reports',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'commit' => 'commit',
            ),
          ),
          's' => 
          array (
            0 => 'repositories_workspace_repo_slug_commit_commit_reports_reportId',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'commit' => 'commit',
              'reportId' => 'reportId',
            ),
          ),
          't' => 
          array (
            0 => 'repositories_workspace_repo_slug_commit_commit_reports_reportId_annotations',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'commit' => 'commit',
              'reportId' => 'reportId',
            ),
          ),
          'u' => 
          array (
            0 => 'repositories_workspace_repo_slug_commit_commit_reports_reportId_annotations_annotationId',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'commit' => 'commit',
              'reportId' => 'reportId',
              'annotationId' => 'annotationId',
            ),
          ),
          'v' => 
          array (
            0 => 'repositories_workspace_repo_slug_commit_commit_statuses',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'commit' => 'commit',
            ),
          ),
          'w' => 
          array (
            0 => 'repositories_workspace_repo_slug_commit_commit_statuses_build',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'commit' => 'commit',
            ),
          ),
          'x' => 
          array (
            0 => 'repositories_workspace_repo_slug_commit_commit_statuses_build_key',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'commit' => 'commit',
              'key' => 'key',
            ),
          ),
          'y' => 
          array (
            0 => 'repositories_workspace_repo_slug_commits',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
            ),
          ),
          'z' => 
          array (
            0 => 'repositories_workspace_repo_slug_commits_revision',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'revision' => 'revision',
            ),
          ),
          'aa' => 
          array (
            0 => 'repositories_workspace_repo_slug_components',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
            ),
          ),
          'ab' => 
          array (
            0 => 'repositories_workspace_repo_slug_components_component_id',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'component_id' => 'component_id',
            ),
          ),
        ),
      ),
      1 => 
      array (
        'regex' => '~^(?|/repositories/([^/]+)/([^/]+)/default\\-reviewers(*MARK:a)|/repositories/([^/]+)/([^/]+)/default\\-reviewers/([^/]+)(*MARK:b)|/repositories/([^/]+)/([^/]+)/deploy\\-keys(*MARK:c)|/repositories/([^/]+)/([^/]+)/deploy\\-keys/([^/]+)(*MARK:d)|/repositories/([^/]+)/([^/]+)/deployments/(*MARK:e)|/repositories/([^/]+)/([^/]+)/deployments/([^/]+)(*MARK:f)|/repositories/([^/]+)/([^/]+)/deployments_config/environments/([^/]+)/variables(*MARK:g)|/repositories/([^/]+)/([^/]+)/deployments_config/environments/([^/]+)/variables/([^/]+)(*MARK:h)|/repositories/([^/]+)/([^/]+)/diff/([^/]+)(*MARK:i)|/repositories/([^/]+)/([^/]+)/diffstat/([^/]+)(*MARK:j)|/repositories/([^/]+)/([^/]+)/downloads(*MARK:k)|/repositories/([^/]+)/([^/]+)/downloads/([^/]+)(*MARK:l)|/repositories/([^/]+)/([^/]+)/environments/(*MARK:m)|/repositories/([^/]+)/([^/]+)/environments/([^/]+)(*MARK:n)|/repositories/([^/]+)/([^/]+)/environments/([^/]+)/changes/(*MARK:o)|/repositories/([^/]+)/([^/]+)/filehistory/([^/]+)/([^/]+)(*MARK:p)|/repositories/([^/]+)/([^/]+)/forks(*MARK:q)|/repositories/([^/]+)/([^/]+)/hooks(*MARK:r)|/repositories/([^/]+)/([^/]+)/hooks/([^/]+)(*MARK:s)|/repositories/([^/]+)/([^/]+)/issues(*MARK:t)|/repositories/([^/]+)/([^/]+)/issues/export(*MARK:u)|/repositories/([^/]+)/([^/]+)/issues/export/([^/]+)\\-issues\\-([^/]+)\\.zip(*MARK:v)|/repositories/([^/]+)/([^/]+)/issues/import(*MARK:w)|/repositories/([^/]+)/([^/]+)/issues/([^/]+)(*MARK:x)|/repositories/([^/]+)/([^/]+)/issues/([^/]+)/attachments(*MARK:y)|/repositories/([^/]+)/([^/]+)/issues/([^/]+)/attachments/([^/]+)(*MARK:z)|/repositories/([^/]+)/([^/]+)/issues/([^/]+)/changes(*MARK:aa)|/repositories/([^/]+)/([^/]+)/issues/([^/]+)/changes/([^/]+)(*MARK:ab))$~',
        'routeMap' => 
        array (
          'a' => 
          array (
            0 => 'repositories_workspace_repo_slug_default_reviewers',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
            ),
          ),
          'b' => 
          array (
            0 => 'repositories_workspace_repo_slug_default_reviewers_target_username',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'target_username' => 'target_username',
            ),
          ),
          'c' => 
          array (
            0 => 'repositories_workspace_repo_slug_deploy_keys',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
            ),
          ),
          'd' => 
          array (
            0 => 'repositories_workspace_repo_slug_deploy_keys_key_id',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'key_id' => 'key_id',
            ),
          ),
          'e' => 
          array (
            0 => 'repositories_workspace_repo_slug_deployments',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
            ),
          ),
          'f' => 
          array (
            0 => 'repositories_workspace_repo_slug_deployments_deployment_uuid',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'deployment_uuid' => 'deployment_uuid',
            ),
          ),
          'g' => 
          array (
            0 => 'repositories_workspace_repo_slug_deployments_config_environments_environment_uuid_variables',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'environment_uuid' => 'environment_uuid',
            ),
          ),
          'h' => 
          array (
            0 => 'repositories_workspace_repo_slug_deployments_config_environments_environment_uuid_variables_variable_uuid',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'environment_uuid' => 'environment_uuid',
              'variable_uuid' => 'variable_uuid',
            ),
          ),
          'i' => 
          array (
            0 => 'repositories_workspace_repo_slug_diff_spec',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'spec' => 'spec',
            ),
          ),
          'j' => 
          array (
            0 => 'repositories_workspace_repo_slug_diffstat_spec',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'spec' => 'spec',
            ),
          ),
          'k' => 
          array (
            0 => 'repositories_workspace_repo_slug_downloads',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
            ),
          ),
          'l' => 
          array (
            0 => 'repositories_workspace_repo_slug_downloads_filename',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'filename' => 'filename',
            ),
          ),
          'm' => 
          array (
            0 => 'repositories_workspace_repo_slug_environments',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
            ),
          ),
          'n' => 
          array (
            0 => 'repositories_workspace_repo_slug_environments_environment_uuid',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'environment_uuid' => 'environment_uuid',
            ),
          ),
          'o' => 
          array (
            0 => 'repositories_workspace_repo_slug_environments_environment_uuid_changes',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'environment_uuid' => 'environment_uuid',
            ),
          ),
          'p' => 
          array (
            0 => 'repositories_workspace_repo_slug_filehistory_commit_path',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'commit' => 'commit',
              'path' => 'path',
            ),
          ),
          'q' => 
          array (
            0 => 'repositories_workspace_repo_slug_forks',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
            ),
          ),
          'r' => 
          array (
            0 => 'repositories_workspace_repo_slug_hooks',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
            ),
          ),
          's' => 
          array (
            0 => 'repositories_workspace_repo_slug_hooks_uid',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'uid' => 'uid',
            ),
          ),
          't' => 
          array (
            0 => 'repositories_workspace_repo_slug_issues',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
            ),
          ),
          'u' => 
          array (
            0 => 'repositories_workspace_repo_slug_issues_export',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
            ),
          ),
          'v' => 
          array (
            0 => 'repositories_workspace_repo_slug_issues_export_repo_name_issues_task_id_zip',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'repo_name' => 'repo_name',
              'task_id' => 'task_id',
            ),
          ),
          'w' => 
          array (
            0 => 'repositories_workspace_repo_slug_issues_import',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
            ),
          ),
          'x' => 
          array (
            0 => 'repositories_workspace_repo_slug_issues_issue_id',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'issue_id' => 'issue_id',
            ),
          ),
          'y' => 
          array (
            0 => 'repositories_workspace_repo_slug_issues_issue_id_attachments',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'issue_id' => 'issue_id',
            ),
          ),
          'z' => 
          array (
            0 => 'repositories_workspace_repo_slug_issues_issue_id_attachments_path',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'issue_id' => 'issue_id',
              'path' => 'path',
            ),
          ),
          'aa' => 
          array (
            0 => 'repositories_workspace_repo_slug_issues_issue_id_changes',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'issue_id' => 'issue_id',
            ),
          ),
          'ab' => 
          array (
            0 => 'repositories_workspace_repo_slug_issues_issue_id_changes_change_id',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'issue_id' => 'issue_id',
              'change_id' => 'change_id',
            ),
          ),
        ),
      ),
      2 => 
      array (
        'regex' => '~^(?|/repositories/([^/]+)/([^/]+)/issues/([^/]+)/comments(*MARK:a)|/repositories/([^/]+)/([^/]+)/issues/([^/]+)/comments/([^/]+)(*MARK:b)|/repositories/([^/]+)/([^/]+)/issues/([^/]+)/vote(*MARK:c)|/repositories/([^/]+)/([^/]+)/issues/([^/]+)/watch(*MARK:d)|/repositories/([^/]+)/([^/]+)/merge\\-base/([^/]+)(*MARK:e)|/repositories/([^/]+)/([^/]+)/milestones(*MARK:f)|/repositories/([^/]+)/([^/]+)/milestones/([^/]+)(*MARK:g)|/repositories/([^/]+)/([^/]+)/patch/([^/]+)(*MARK:h)|/repositories/([^/]+)/([^/]+)/pipelines\\-config/caches/(*MARK:i)|/repositories/([^/]+)/([^/]+)/pipelines\\-config/caches/([^/]+)(*MARK:j)|/repositories/([^/]+)/([^/]+)/pipelines\\-config/caches/([^/]+)/content\\-uri(*MARK:k)|/repositories/([^/]+)/([^/]+)/pipelines/(*MARK:l)|/repositories/([^/]+)/([^/]+)/pipelines/([^/]+)(*MARK:m)|/repositories/([^/]+)/([^/]+)/pipelines/([^/]+)/steps/(*MARK:n)|/repositories/([^/]+)/([^/]+)/pipelines/([^/]+)/steps/([^/]+)(*MARK:o)|/repositories/([^/]+)/([^/]+)/pipelines/([^/]+)/steps/([^/]+)/log(*MARK:p)|/repositories/([^/]+)/([^/]+)/pipelines/([^/]+)/steps/([^/]+)/logs/([^/]+)(*MARK:q)|/repositories/([^/]+)/([^/]+)/pipelines/([^/]+)/steps/([^/]+)/test_reports(*MARK:r)|/repositories/([^/]+)/([^/]+)/pipelines/([^/]+)/steps/([^/]+)/test_reports/test_cases(*MARK:s)|/repositories/([^/]+)/([^/]+)/pipelines/([^/]+)/steps/([^/]+)/test_reports/test_cases/([^/]+)/test_case_reasons(*MARK:t)|/repositories/([^/]+)/([^/]+)/pipelines/([^/]+)/stopPipeline(*MARK:u)|/repositories/([^/]+)/([^/]+)/pipelines_config(*MARK:v)|/repositories/([^/]+)/([^/]+)/pipelines_config/build_number(*MARK:w)|/repositories/([^/]+)/([^/]+)/pipelines_config/schedules/(*MARK:x)|/repositories/([^/]+)/([^/]+)/pipelines_config/schedules/([^/]+)(*MARK:y)|/repositories/([^/]+)/([^/]+)/pipelines_config/schedules/([^/]+)/executions/(*MARK:z)|/repositories/([^/]+)/([^/]+)/pipelines_config/ssh/key_pair(*MARK:aa)|/repositories/([^/]+)/([^/]+)/pipelines_config/ssh/known_hosts/(*MARK:ab))$~',
        'routeMap' => 
        array (
          'a' => 
          array (
            0 => 'repositories_workspace_repo_slug_issues_issue_id_comments',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'issue_id' => 'issue_id',
            ),
          ),
          'b' => 
          array (
            0 => 'repositories_workspace_repo_slug_issues_issue_id_comments_comment_id',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'issue_id' => 'issue_id',
              'comment_id' => 'comment_id',
            ),
          ),
          'c' => 
          array (
            0 => 'repositories_workspace_repo_slug_issues_issue_id_vote',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'issue_id' => 'issue_id',
            ),
          ),
          'd' => 
          array (
            0 => 'repositories_workspace_repo_slug_issues_issue_id_watch',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'issue_id' => 'issue_id',
            ),
          ),
          'e' => 
          array (
            0 => 'repositories_workspace_repo_slug_merge_base_revspec',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'revspec' => 'revspec',
            ),
          ),
          'f' => 
          array (
            0 => 'repositories_workspace_repo_slug_milestones',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
            ),
          ),
          'g' => 
          array (
            0 => 'repositories_workspace_repo_slug_milestones_milestone_id',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'milestone_id' => 'milestone_id',
            ),
          ),
          'h' => 
          array (
            0 => 'repositories_workspace_repo_slug_patch_spec',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'spec' => 'spec',
            ),
          ),
          'i' => 
          array (
            0 => 'repositories_workspace_repo_slug_pipelines_config_caches',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
            ),
          ),
          'j' => 
          array (
            0 => 'repositories_workspace_repo_slug_pipelines_config_caches_cache_uuid',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'cache_uuid' => 'cache_uuid',
            ),
          ),
          'k' => 
          array (
            0 => 'repositories_workspace_repo_slug_pipelines_config_caches_cache_uuid_content_uri',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'cache_uuid' => 'cache_uuid',
            ),
          ),
          'l' => 
          array (
            0 => 'repositories_workspace_repo_slug_pipelines',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
            ),
          ),
          'm' => 
          array (
            0 => 'repositories_workspace_repo_slug_pipelines_pipeline_uuid',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'pipeline_uuid' => 'pipeline_uuid',
            ),
          ),
          'n' => 
          array (
            0 => 'repositories_workspace_repo_slug_pipelines_pipeline_uuid_steps',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'pipeline_uuid' => 'pipeline_uuid',
            ),
          ),
          'o' => 
          array (
            0 => 'repositories_workspace_repo_slug_pipelines_pipeline_uuid_steps_step_uuid',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'pipeline_uuid' => 'pipeline_uuid',
              'step_uuid' => 'step_uuid',
            ),
          ),
          'p' => 
          array (
            0 => 'repositories_workspace_repo_slug_pipelines_pipeline_uuid_steps_step_uuid_log',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'pipeline_uuid' => 'pipeline_uuid',
              'step_uuid' => 'step_uuid',
            ),
          ),
          'q' => 
          array (
            0 => 'repositories_workspace_repo_slug_pipelines_pipeline_uuid_steps_step_uuid_logs_log_uuid',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'pipeline_uuid' => 'pipeline_uuid',
              'step_uuid' => 'step_uuid',
              'log_uuid' => 'log_uuid',
            ),
          ),
          'r' => 
          array (
            0 => 'repositories_workspace_repo_slug_pipelines_pipeline_uuid_steps_step_uuid_test_reports',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'pipeline_uuid' => 'pipeline_uuid',
              'step_uuid' => 'step_uuid',
            ),
          ),
          's' => 
          array (
            0 => 'repositories_workspace_repo_slug_pipelines_pipeline_uuid_steps_step_uuid_test_reports_test_cases',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'pipeline_uuid' => 'pipeline_uuid',
              'step_uuid' => 'step_uuid',
            ),
          ),
          't' => 
          array (
            0 => 'repositories_workspace_repo_slug_pipelines_pipeline_uuid_steps_step_uuid_test_reports_test_cases_test_case_uuid_test_case_reasons',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'pipeline_uuid' => 'pipeline_uuid',
              'step_uuid' => 'step_uuid',
              'test_case_uuid' => 'test_case_uuid',
            ),
          ),
          'u' => 
          array (
            0 => 'repositories_workspace_repo_slug_pipelines_pipeline_uuid_stopPipeline',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'pipeline_uuid' => 'pipeline_uuid',
            ),
          ),
          'v' => 
          array (
            0 => 'repositories_workspace_repo_slug_pipelines_config',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
            ),
          ),
          'w' => 
          array (
            0 => 'repositories_workspace_repo_slug_pipelines_config_build_number',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
            ),
          ),
          'x' => 
          array (
            0 => 'repositories_workspace_repo_slug_pipelines_config_schedules',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
            ),
          ),
          'y' => 
          array (
            0 => 'repositories_workspace_repo_slug_pipelines_config_schedules_schedule_uuid',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'schedule_uuid' => 'schedule_uuid',
            ),
          ),
          'z' => 
          array (
            0 => 'repositories_workspace_repo_slug_pipelines_config_schedules_schedule_uuid_executions',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'schedule_uuid' => 'schedule_uuid',
            ),
          ),
          'aa' => 
          array (
            0 => 'repositories_workspace_repo_slug_pipelines_config_ssh_key_pair',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
            ),
          ),
          'ab' => 
          array (
            0 => 'repositories_workspace_repo_slug_pipelines_config_ssh_known_hosts',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
            ),
          ),
        ),
      ),
      3 => 
      array (
        'regex' => '~^(?|/repositories/([^/]+)/([^/]+)/pipelines_config/ssh/known_hosts/([^/]+)(*MARK:a)|/repositories/([^/]+)/([^/]+)/pipelines_config/variables/(*MARK:b)|/repositories/([^/]+)/([^/]+)/pipelines_config/variables/([^/]+)(*MARK:c)|/repositories/([^/]+)/([^/]+)/properties/([^/]+)/([^/]+)(*MARK:d)|/repositories/([^/]+)/([^/]+)/pullrequests(*MARK:e)|/repositories/([^/]+)/([^/]+)/pullrequests/activity(*MARK:f)|/repositories/([^/]+)/([^/]+)/pullrequests/([^/]+)(*MARK:g)|/repositories/([^/]+)/([^/]+)/pullrequests/([^/]+)/activity(*MARK:h)|/repositories/([^/]+)/([^/]+)/pullrequests/([^/]+)/approve(*MARK:i)|/repositories/([^/]+)/([^/]+)/pullrequests/([^/]+)/comments(*MARK:j)|/repositories/([^/]+)/([^/]+)/pullrequests/([^/]+)/comments/([^/]+)(*MARK:k)|/repositories/([^/]+)/([^/]+)/pullrequests/([^/]+)/commits(*MARK:l)|/repositories/([^/]+)/([^/]+)/pullrequests/([^/]+)/decline(*MARK:m)|/repositories/([^/]+)/([^/]+)/pullrequests/([^/]+)/diff(*MARK:n)|/repositories/([^/]+)/([^/]+)/pullrequests/([^/]+)/diffstat(*MARK:o)|/repositories/([^/]+)/([^/]+)/pullrequests/([^/]+)/merge(*MARK:p)|/repositories/([^/]+)/([^/]+)/pullrequests/([^/]+)/merge/task\\-status/([^/]+)(*MARK:q)|/repositories/([^/]+)/([^/]+)/pullrequests/([^/]+)/patch(*MARK:r)|/repositories/([^/]+)/([^/]+)/pullrequests/([^/]+)/request\\-changes(*MARK:s)|/repositories/([^/]+)/([^/]+)/pullrequests/([^/]+)/statuses(*MARK:t)|/repositories/([^/]+)/([^/]+)/pullrequests/([^/]+)/properties/([^/]+)/([^/]+)(*MARK:u)|/repositories/([^/]+)/([^/]+)/refs(*MARK:v)|/repositories/([^/]+)/([^/]+)/refs/branches(*MARK:w)|/repositories/([^/]+)/([^/]+)/refs/branches/([^/]+)(*MARK:x)|/repositories/([^/]+)/([^/]+)/refs/tags(*MARK:y)|/repositories/([^/]+)/([^/]+)/refs/tags/([^/]+)(*MARK:z)|/repositories/([^/]+)/([^/]+)/src(*MARK:aa)|/repositories/([^/]+)/([^/]+)/src/([^/]+)/([^/]+)(*MARK:ab))$~',
        'routeMap' => 
        array (
          'a' => 
          array (
            0 => 'repositories_workspace_repo_slug_pipelines_config_ssh_known_hosts_known_host_uuid',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'known_host_uuid' => 'known_host_uuid',
            ),
          ),
          'b' => 
          array (
            0 => 'repositories_workspace_repo_slug_pipelines_config_variables',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
            ),
          ),
          'c' => 
          array (
            0 => 'repositories_workspace_repo_slug_pipelines_config_variables_variable_uuid',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'variable_uuid' => 'variable_uuid',
            ),
          ),
          'd' => 
          array (
            0 => 'repositories_workspace_repo_slug_properties_app_key_property_name',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'app_key' => 'app_key',
              'property_name' => 'property_name',
            ),
          ),
          'e' => 
          array (
            0 => 'repositories_workspace_repo_slug_pullrequests',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
            ),
          ),
          'f' => 
          array (
            0 => 'repositories_workspace_repo_slug_pullrequests_activity',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
            ),
          ),
          'g' => 
          array (
            0 => 'repositories_workspace_repo_slug_pullrequests_pull_request_id',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'pull_request_id' => 'pull_request_id',
            ),
          ),
          'h' => 
          array (
            0 => 'repositories_workspace_repo_slug_pullrequests_pull_request_id_activity',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'pull_request_id' => 'pull_request_id',
            ),
          ),
          'i' => 
          array (
            0 => 'repositories_workspace_repo_slug_pullrequests_pull_request_id_approve',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'pull_request_id' => 'pull_request_id',
            ),
          ),
          'j' => 
          array (
            0 => 'repositories_workspace_repo_slug_pullrequests_pull_request_id_comments',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'pull_request_id' => 'pull_request_id',
            ),
          ),
          'k' => 
          array (
            0 => 'repositories_workspace_repo_slug_pullrequests_pull_request_id_comments_comment_id',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'pull_request_id' => 'pull_request_id',
              'comment_id' => 'comment_id',
            ),
          ),
          'l' => 
          array (
            0 => 'repositories_workspace_repo_slug_pullrequests_pull_request_id_commits',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'pull_request_id' => 'pull_request_id',
            ),
          ),
          'm' => 
          array (
            0 => 'repositories_workspace_repo_slug_pullrequests_pull_request_id_decline',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'pull_request_id' => 'pull_request_id',
            ),
          ),
          'n' => 
          array (
            0 => 'repositories_workspace_repo_slug_pullrequests_pull_request_id_diff',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'pull_request_id' => 'pull_request_id',
            ),
          ),
          'o' => 
          array (
            0 => 'repositories_workspace_repo_slug_pullrequests_pull_request_id_diffstat',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'pull_request_id' => 'pull_request_id',
            ),
          ),
          'p' => 
          array (
            0 => 'repositories_workspace_repo_slug_pullrequests_pull_request_id_merge',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'pull_request_id' => 'pull_request_id',
            ),
          ),
          'q' => 
          array (
            0 => 'repositories_workspace_repo_slug_pullrequests_pull_request_id_merge_task_status_task_id',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'pull_request_id' => 'pull_request_id',
              'task_id' => 'task_id',
            ),
          ),
          'r' => 
          array (
            0 => 'repositories_workspace_repo_slug_pullrequests_pull_request_id_patch',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'pull_request_id' => 'pull_request_id',
            ),
          ),
          's' => 
          array (
            0 => 'repositories_workspace_repo_slug_pullrequests_pull_request_id_request_changes',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'pull_request_id' => 'pull_request_id',
            ),
          ),
          't' => 
          array (
            0 => 'repositories_workspace_repo_slug_pullrequests_pull_request_id_statuses',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'pull_request_id' => 'pull_request_id',
            ),
          ),
          'u' => 
          array (
            0 => 'repositories_workspace_repo_slug_pullrequests_pullrequest_id_properties_app_key_property_name',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'pullrequest_id' => 'pullrequest_id',
              'app_key' => 'app_key',
              'property_name' => 'property_name',
            ),
          ),
          'v' => 
          array (
            0 => 'repositories_workspace_repo_slug_refs',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
            ),
          ),
          'w' => 
          array (
            0 => 'repositories_workspace_repo_slug_refs_branches',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
            ),
          ),
          'x' => 
          array (
            0 => 'repositories_workspace_repo_slug_refs_branches_name',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'name' => 'name',
            ),
          ),
          'y' => 
          array (
            0 => 'repositories_workspace_repo_slug_refs_tags',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
            ),
          ),
          'z' => 
          array (
            0 => 'repositories_workspace_repo_slug_refs_tags_name',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'name' => 'name',
            ),
          ),
          'aa' => 
          array (
            0 => 'repositories_workspace_repo_slug_src',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
            ),
          ),
          'ab' => 
          array (
            0 => 'repositories_workspace_repo_slug_src_commit_path',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'commit' => 'commit',
              'path' => 'path',
            ),
          ),
        ),
      ),
      4 => 
      array (
        'regex' => '~^(?|/repositories/([^/]+)/([^/]+)/versions(*MARK:a)|/repositories/([^/]+)/([^/]+)/versions/([^/]+)(*MARK:b)|/repositories/([^/]+)/([^/]+)/watchers(*MARK:c)|/snippets/([^/]+)(*MARK:d)|/snippets/([^/]+)/([^/]+)(*MARK:e)|/snippets/([^/]+)/([^/]+)/comments(*MARK:f)|/snippets/([^/]+)/([^/]+)/comments/([^/]+)(*MARK:g)|/snippets/([^/]+)/([^/]+)/commits(*MARK:h)|/snippets/([^/]+)/([^/]+)/commits/([^/]+)(*MARK:i)|/snippets/([^/]+)/([^/]+)/files/([^/]+)(*MARK:j)|/snippets/([^/]+)/([^/]+)/watch(*MARK:k)|/snippets/([^/]+)/([^/]+)/watchers(*MARK:l)|/snippets/([^/]+)/([^/]+)/([^/]+)(*MARK:m)|/snippets/([^/]+)/([^/]+)/([^/]+)/files/([^/]+)(*MARK:n)|/snippets/([^/]+)/([^/]+)/([^/]+)/diff(*MARK:o)|/snippets/([^/]+)/([^/]+)/([^/]+)/patch(*MARK:p)|/teams/([^/]+)(*MARK:q)|/teams/([^/]+)/followers(*MARK:r)|/teams/([^/]+)/following(*MARK:s)|/teams/([^/]+)/members(*MARK:t)|/teams/([^/]+)/permissions(*MARK:u)|/teams/([^/]+)/permissions/repositories(*MARK:v)|/teams/([^/]+)/permissions/repositories/([^/]+)(*MARK:w)|/teams/([^/]+)/pipelines_config/variables/(*MARK:x)|/teams/([^/]+)/pipelines_config/variables/([^/]+)(*MARK:y)|/teams/([^/]+)/projects/(*MARK:z)|/teams/([^/]+)/projects/([^/]+)(*MARK:aa)|/teams/([^/]+)/search/code(*MARK:ab))$~',
        'routeMap' => 
        array (
          'a' => 
          array (
            0 => 'repositories_workspace_repo_slug_versions',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
            ),
          ),
          'b' => 
          array (
            0 => 'repositories_workspace_repo_slug_versions_version_id',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
              'version_id' => 'version_id',
            ),
          ),
          'c' => 
          array (
            0 => 'repositories_workspace_repo_slug_watchers',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
            ),
          ),
          'd' => 
          array (
            0 => 'snippets_workspace',
            1 => 
            array (
              'workspace' => 'workspace',
            ),
          ),
          'e' => 
          array (
            0 => 'snippets_workspace_encoded_id',
            1 => 
            array (
              'workspace' => 'workspace',
              'encoded_id' => 'encoded_id',
            ),
          ),
          'f' => 
          array (
            0 => 'snippets_workspace_encoded_id_comments',
            1 => 
            array (
              'workspace' => 'workspace',
              'encoded_id' => 'encoded_id',
            ),
          ),
          'g' => 
          array (
            0 => 'snippets_workspace_encoded_id_comments_comment_id',
            1 => 
            array (
              'workspace' => 'workspace',
              'encoded_id' => 'encoded_id',
              'comment_id' => 'comment_id',
            ),
          ),
          'h' => 
          array (
            0 => 'snippets_workspace_encoded_id_commits',
            1 => 
            array (
              'workspace' => 'workspace',
              'encoded_id' => 'encoded_id',
            ),
          ),
          'i' => 
          array (
            0 => 'snippets_workspace_encoded_id_commits_revision',
            1 => 
            array (
              'workspace' => 'workspace',
              'encoded_id' => 'encoded_id',
              'revision' => 'revision',
            ),
          ),
          'j' => 
          array (
            0 => 'snippets_workspace_encoded_id_files_path',
            1 => 
            array (
              'workspace' => 'workspace',
              'encoded_id' => 'encoded_id',
              'path' => 'path',
            ),
          ),
          'k' => 
          array (
            0 => 'snippets_workspace_encoded_id_watch',
            1 => 
            array (
              'workspace' => 'workspace',
              'encoded_id' => 'encoded_id',
            ),
          ),
          'l' => 
          array (
            0 => 'snippets_workspace_encoded_id_watchers',
            1 => 
            array (
              'workspace' => 'workspace',
              'encoded_id' => 'encoded_id',
            ),
          ),
          'm' => 
          array (
            0 => 'snippets_workspace_encoded_id_node_id',
            1 => 
            array (
              'workspace' => 'workspace',
              'encoded_id' => 'encoded_id',
              'node_id' => 'node_id',
            ),
          ),
          'n' => 
          array (
            0 => 'snippets_workspace_encoded_id_node_id_files_path',
            1 => 
            array (
              'workspace' => 'workspace',
              'encoded_id' => 'encoded_id',
              'node_id' => 'node_id',
              'path' => 'path',
            ),
          ),
          'o' => 
          array (
            0 => 'snippets_workspace_encoded_id_revision_diff',
            1 => 
            array (
              'workspace' => 'workspace',
              'encoded_id' => 'encoded_id',
              'revision' => 'revision',
            ),
          ),
          'p' => 
          array (
            0 => 'snippets_workspace_encoded_id_revision_patch',
            1 => 
            array (
              'workspace' => 'workspace',
              'encoded_id' => 'encoded_id',
              'revision' => 'revision',
            ),
          ),
          'q' => 
          array (
            0 => 'teams_username',
            1 => 
            array (
              'username' => 'username',
            ),
          ),
          'r' => 
          array (
            0 => 'teams_username_followers',
            1 => 
            array (
              'username' => 'username',
            ),
          ),
          's' => 
          array (
            0 => 'teams_username_following',
            1 => 
            array (
              'username' => 'username',
            ),
          ),
          't' => 
          array (
            0 => 'teams_username_members',
            1 => 
            array (
              'username' => 'username',
            ),
          ),
          'u' => 
          array (
            0 => 'teams_username_permissions',
            1 => 
            array (
              'username' => 'username',
            ),
          ),
          'v' => 
          array (
            0 => 'teams_username_permissions_repositories',
            1 => 
            array (
              'username' => 'username',
            ),
          ),
          'w' => 
          array (
            0 => 'teams_username_permissions_repositories_repo_slug',
            1 => 
            array (
              'username' => 'username',
              'repo_slug' => 'repo_slug',
            ),
          ),
          'x' => 
          array (
            0 => 'teams_username_pipelines_config_variables',
            1 => 
            array (
              'username' => 'username',
            ),
          ),
          'y' => 
          array (
            0 => 'teams_username_pipelines_config_variables_variable_uuid',
            1 => 
            array (
              'username' => 'username',
              'variable_uuid' => 'variable_uuid',
            ),
          ),
          'z' => 
          array (
            0 => 'teams_username_projects',
            1 => 
            array (
              'username' => 'username',
            ),
          ),
          'aa' => 
          array (
            0 => 'teams_username_projects_project_key',
            1 => 
            array (
              'username' => 'username',
              'project_key' => 'project_key',
            ),
          ),
          'ab' => 
          array (
            0 => 'teams_username_search_code',
            1 => 
            array (
              'username' => 'username',
            ),
          ),
        ),
      ),
      5 => 
      array (
        'regex' => '~^(?|/teams/([^/]+)/repositories(*MARK:a)|/user/emails/([^/]+)(*MARK:b)|/users/([^/]+)(*MARK:c)|/users/([^/]+)/pipelines_config/variables/(*MARK:d)|/users/([^/]+)/pipelines_config/variables/([^/]+)(*MARK:e)|/users/([^/]+)/properties/([^/]+)/([^/]+)(*MARK:f)|/users/([^/]+)/search/code(*MARK:g)|/users/([^/]+)/ssh\\-keys(*MARK:h)|/users/([^/]+)/ssh\\-keys/([^/]+)(*MARK:i)|/users/([^/]+)/members(*MARK:j)|/users/([^/]+)/repositories(*MARK:k)|/workspaces/([^/]+)(*MARK:l)|/workspaces/([^/]+)/hooks(*MARK:m)|/workspaces/([^/]+)/hooks/([^/]+)(*MARK:n)|/workspaces/([^/]+)/members(*MARK:o)|/workspaces/([^/]+)/members/([^/]+)(*MARK:p)|/workspaces/([^/]+)/permissions(*MARK:q)|/workspaces/([^/]+)/permissions/repositories(*MARK:r)|/workspaces/([^/]+)/permissions/repositories/([^/]+)(*MARK:s)|/workspaces/([^/]+)/pipelines\\-config/identity/oidc/\\.well\\-known/openid\\-configuration(*MARK:t)|/workspaces/([^/]+)/pipelines\\-config/identity/oidc/keys\\.json(*MARK:u)|/workspaces/([^/]+)/pipelines\\-config/variables(*MARK:v)|/workspaces/([^/]+)/pipelines\\-config/variables/([^/]+)(*MARK:w)|/workspaces/([^/]+)/projects(*MARK:x)|/workspaces/([^/]+)/projects/([^/]+)(*MARK:y)|/workspaces/([^/]+)/search/code(*MARK:z))$~',
        'routeMap' => 
        array (
          'a' => 
          array (
            0 => 'teams_workspace_repositories',
            1 => 
            array (
              'workspace' => 'workspace',
            ),
          ),
          'b' => 
          array (
            0 => 'user_emails_email',
            1 => 
            array (
              'email' => 'email',
            ),
          ),
          'c' => 
          array (
            0 => 'users_selected_user',
            1 => 
            array (
              'selected_user' => 'selected_user',
            ),
          ),
          'd' => 
          array (
            0 => 'users_selected_user_pipelines_config_variables',
            1 => 
            array (
              'selected_user' => 'selected_user',
            ),
          ),
          'e' => 
          array (
            0 => 'users_selected_user_pipelines_config_variables_variable_uuid',
            1 => 
            array (
              'selected_user' => 'selected_user',
              'variable_uuid' => 'variable_uuid',
            ),
          ),
          'f' => 
          array (
            0 => 'users_selected_user_properties_app_key_property_name',
            1 => 
            array (
              'selected_user' => 'selected_user',
              'app_key' => 'app_key',
              'property_name' => 'property_name',
            ),
          ),
          'g' => 
          array (
            0 => 'users_selected_user_search_code',
            1 => 
            array (
              'selected_user' => 'selected_user',
            ),
          ),
          'h' => 
          array (
            0 => 'users_selected_user_ssh_keys',
            1 => 
            array (
              'selected_user' => 'selected_user',
            ),
          ),
          'i' => 
          array (
            0 => 'users_selected_user_ssh_keys_key_id',
            1 => 
            array (
              'selected_user' => 'selected_user',
              'key_id' => 'key_id',
            ),
          ),
          'j' => 
          array (
            0 => 'users_username_members',
            1 => 
            array (
              'username' => 'username',
            ),
          ),
          'k' => 
          array (
            0 => 'users_workspace_repositories',
            1 => 
            array (
              'workspace' => 'workspace',
            ),
          ),
          'l' => 
          array (
            0 => 'workspaces_workspace',
            1 => 
            array (
              'workspace' => 'workspace',
            ),
          ),
          'm' => 
          array (
            0 => 'workspaces_workspace_hooks',
            1 => 
            array (
              'workspace' => 'workspace',
            ),
          ),
          'n' => 
          array (
            0 => 'workspaces_workspace_hooks_uid',
            1 => 
            array (
              'workspace' => 'workspace',
              'uid' => 'uid',
            ),
          ),
          'o' => 
          array (
            0 => 'workspaces_workspace_members',
            1 => 
            array (
              'workspace' => 'workspace',
            ),
          ),
          'p' => 
          array (
            0 => 'workspaces_workspace_members_member',
            1 => 
            array (
              'workspace' => 'workspace',
              'member' => 'member',
            ),
          ),
          'q' => 
          array (
            0 => 'workspaces_workspace_permissions',
            1 => 
            array (
              'workspace' => 'workspace',
            ),
          ),
          'r' => 
          array (
            0 => 'workspaces_workspace_permissions_repositories',
            1 => 
            array (
              'workspace' => 'workspace',
            ),
          ),
          's' => 
          array (
            0 => 'workspaces_workspace_permissions_repositories_repo_slug',
            1 => 
            array (
              'workspace' => 'workspace',
              'repo_slug' => 'repo_slug',
            ),
          ),
          't' => 
          array (
            0 => 'workspaces_workspace_pipelines_config_identity_oidc_well_known_openid_configuration',
            1 => 
            array (
              'workspace' => 'workspace',
            ),
          ),
          'u' => 
          array (
            0 => 'workspaces_workspace_pipelines_config_identity_oidc_keys_json',
            1 => 
            array (
              'workspace' => 'workspace',
            ),
          ),
          'v' => 
          array (
            0 => 'workspaces_workspace_pipelines_config_variables',
            1 => 
            array (
              'workspace' => 'workspace',
            ),
          ),
          'w' => 
          array (
            0 => 'workspaces_workspace_pipelines_config_variables_variable_uuid',
            1 => 
            array (
              'workspace' => 'workspace',
              'variable_uuid' => 'variable_uuid',
            ),
          ),
          'x' => 
          array (
            0 => 'workspaces_workspace_projects',
            1 => 
            array (
              'workspace' => 'workspace',
            ),
          ),
          'y' => 
          array (
            0 => 'workspaces_workspace_projects_project_key',
            1 => 
            array (
              'workspace' => 'workspace',
              'project_key' => 'project_key',
            ),
          ),
          'z' => 
          array (
            0 => 'workspaces_workspace_search_code',
            1 => 
            array (
              'workspace' => 'workspace',
            ),
          ),
        ),
      ),
    ),
  ),
);