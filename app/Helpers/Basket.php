<?php

namespace App\Helpers;

class Basket
{
    protected static $loaded = false;
    public static $items = [];

    protected static function load()
    {
        self::$items = session('basket') ?? [];
        self::$loaded = true;
    }
    protected static function save()
    {
        session(['basket' => self::$items]);
    }

    public static function add($commodity, $count = 1)
    {
        if (!self::$loaded) {
            self::load();
        }

        self::change($commodity, $count);

        // self::save();
    }

      public static function remove($commodity)
      {
          if (!self::$loaded) {
              self::load();
          }

          self::change($commodity, 0);

          self::save();
      }


    public static function change($commodity, $count)
    {
        if (!self::$loaded) {
            self::load();
        }

        if ($count == 0) {
            unset(self::$items[$commodity]);
        } else {
            self::$items[$commodity] = $count;
        }

        self::save();
    }

    public static function clear()
    {
        self::$items = [];
        self::save();
    }

    public static function all()
    {
        if (!self::$loaded) {
            self::load();
        }
        return self::$items;
    }
}
