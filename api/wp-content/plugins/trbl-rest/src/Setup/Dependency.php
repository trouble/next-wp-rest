<?php

namespace TRBLRest\Setup;

class Dependency
{
    private $class_name;
    private $error_message;

    public function __construct(string $class_name, string $error_message)
    {
        $this->class_name = $class_name;
        $this->error_message = $error_message;
    }

    public function checkDependency() : bool
    {
        if (!$this->isMet()) {
            add_action('admin_notices', array( $this, 'showAdminNotice' ));
            return false;
        }
        return true;
    }

    public function showAdminNotice()
    {
        $class = 'notice notice-error';
        printf('<div class="%1$s"><p>ACF Form Builder: %2$s</p></div>', esc_attr($class), esc_html($this->error_message));
    }

    private function isMet() : bool
    {
        return class_exists($this->class_name);
    }
}
