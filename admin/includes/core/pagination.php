<?php

/*
 * Licensed under the MIT license - http://opensource.org/licenses/MIT
 * Copyright (c) 2017 Dawid Górecki
 */

namespace Core\Pagination;

/*
   public function getTotalPages()
   public function nextPage()
   public function previousPage()
   public function offset()
   public function hasNext()
   public function hasPrevious()
 */

class Pagination
{
   protected $currentPage;
   protected $itemsOnPage;
   protected $itemsCount;

   public function __construct($page=1, $itemsOnPage=25, $itemsCount=0)
   {
      // bieżąca strona
      $this->currentPage = intval($page) == 0 ? 1 : $page;

      // ilość elementów na stronie
      $this->itemsOnPage = intval($itemsOnPage) == 0 ? 25 : $itemsOnPage;

      // łączna ilość elementów
      $this->itemsCount  = intval($itemsCount);
   }

   public function getTotalPages()
   {
      // ilość stron = ilość elementów / ilość na stronie
      return ceil($this->itemsCount / $this->itemsOnPage);
   }

   public function nextPage()
   {
      // zwraca numer kolejnej strony
      return $this->currentPage + 1;
   }

   public function previousPage()
   {
      // zwraca numer poprzedniej strony
      return$this->currentPage - 1;
   }

   public function offset()
   {
      // liczba elementów do pominięcia - parametr OFFSET dla LIMIT w MySQL
      return ($this->currentPage - 1) * $this->itemsOnPage;
   }

   public function hasNext()
   {
      // sprawdź czy bieżąca strona nie jest ostatnią
      return $this->nextPage() <= $this->getTotalPages()? true : false;
   }

   public function hasPrevious()
   {
      // sprawdź czy bieżąca strona nie jest pierwszą
      return $this->previousPage() >= 1 ? true : false;
   }
}

?>