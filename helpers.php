<?php

$config = [];

if ( ! function_exists('config_set')) {
    /**
     * @param $name
     * @param string $file
     * @return string
     */
    function config_set($name, $file = '') {
        global $config;

        if (file_exists($file)) {
            $config[$name] = include $file;
        }
    }
}

if ( ! function_exists('config')) {
    /**
     * @param $search
     * @return string
     */
    function config($search) {
        global $config;
        return data_get($config, $search);
    }
}

if ( ! function_exists('data_get'))
{
    /**
     * Get an item from an array or object using "dot" notation.
     *
     * @param  mixed   $target
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    function data_get($target, $key, $default = null)
    {
        if (is_null($key)) return $target;
        foreach (explode('.', $key) as $segment)
        {
            if (is_array($target))
            {
                if ( ! array_key_exists($segment, $target))
                {
                    return value($default);
                }
                $target = $target[$segment];
            }
            elseif ($target instanceof ArrayAccess)
            {
                if ( ! isset($target[$segment]))
                {
                    return value($default);
                }
                $target = $target[$segment];
            }
            elseif (is_object($target))
            {
                if ( ! isset($target->{$segment}))
                {
                    return value($default);
                }
                $target = $target->{$segment};
            }
            else
            {
                return value($default);
            }
        }
        return $target;
    }
}

if ( ! function_exists('value'))
{
    /**
     * Return the default value of the given value.
     *
     * @param  mixed  $value
     * @return mixed
     */
    function value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }
}

if ( ! function_exists('plugin_path')) {
    /**
     * Get the path to the plugin folder.
     *
     * @param  string $path
     * @return string
     */
    function plugin_path($path = '')
    {
        return plugin_dir_path(__FILE__) . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}

if (! function_exists('words')) {
    /**
     * Limit the number of words in a string.
     *
     * @param  string  $value
     * @param  int     $words
     * @param  string  $end
     * @return string
     */
    function words($value, $words = 100, $end = '...')
    {
        preg_match('/^\s*+(?:\S++\s*+){1,'.$words.'}/u', $value, $matches);

        if (! isset($matches[0]) || strlen($value) === strlen($matches[0])) {
            return $value;
        }

        return rtrim($matches[0]).$end;
    }
}

if (! function_exists('paragraphs')) {
    /**
     * Limit the number of words in a string.
     *
     * @param  string $value
     * @param int $paragraphs
     * @param  string $end
     * @return string
     */
    function paragraphs($value, $paragraphs = 10, $end = '.')
    {
        $ps = explode('.', $value);

        return implode($end, array_slice($ps, 0, $paragraphs)) . $end;
    }
}

if ( ! function_exists('hwp_die')) {
    /**
     * Get the path to the plugin folder.
     *
     * @param  mixed $data
     * @return string
     */
    function hwp_die($data = '')
    {
        if (is_array($data) || is_object($data)) {
            echo '<pre>';
            print_r($data);
            wp_die();
        }

        wp_die($data);
    }
}