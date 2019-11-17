export const OPEN_MENU_PANEL = 'OPEN_MENU_PANEL';
export const CLOSE_MENU_PANEL = 'CLOSE_MENU_PANEL';
export const CHANGE_PAGE_HEAD_TITLE = 'CHANGE_PAGE_HEAD_TITLE';

export const openMenu = () => ({type: OPEN_MENU_PANEL});
export const closeMenu = () => ({type: CLOSE_MENU_PANEL});
export const changePageHeadTitle = title => ({type: CHANGE_PAGE_HEAD_TITLE, title});
