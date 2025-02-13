/******/ (() => { // webpackBootstrap
/*!*********************!*\
  !*** ./js/index.js ***!
  \*********************/
$(document).ready(function () {
  try {
    console.log('Grid is initialized');
    var grid = new window.prestashop.component.Grid('product_command');
    grid.addExtension(new window.prestashop.component.GridExtensions.SortingExtension());
    grid.addExtension(new window.prestashop.component.GridExtensions.FiltersResetExtension());
    grid.addExtension(new window.prestashop.component.GridExtensions.LinkRowActionExtension());
    grid.addExtension(new window.prestashop.component.GridExtensions.SubmitRowActionExtension());
    grid.addExtension(new window.prestashop.component.GridExtensions.SubmitGridActionExtension());
    grid.addExtension(new window.prestashop.component.GridExtensions.PositionExtension());
  } catch (error) {
    console.error('Error initializing grid:', error);
  }
});
/******/ })()
;
//# sourceMappingURL=mymodule_grid.bundle.js.map