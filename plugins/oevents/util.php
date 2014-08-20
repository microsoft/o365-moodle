<?php
//--------------------------------------------------------------------------------------------------------------------------------------------
// Common utility methods:

// check if given user is a teacher in the given course
function is_teacher($course_id, $user_id) {
    //teacher role comes with courses.
    $context = get_context_instance(CONTEXT_COURSE, $course_id, true);
    $roles = get_user_roles($context, $user_id, true);

    foreach ($roles as $role) {
        if ($role->roleid == 3) {
            return true;
        }
    }

    return false;
}

?>