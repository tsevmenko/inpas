{"version":3,"file":"script.min.js","sources":["script.js"],"names":["BX","namespace","Sale","component","location","selector","system","ui","widget","opts","nf","this","parentConstruct","merge","editUrl","pageSize","hugeTailLen","selectOnBlur","selectOnEnter","autoSelectIfOneVariant","selectByClick","closePopupOnOuterClick","chooseUsingArrows","usePagingOnScroll","paginatedRequest","callback","DoNothing","vars","cache","nodes","grp","path","selected","selectedNodesShowOffset","selectedParentNode","selectedParentType","expectChooseAll","spMutex","parent","child","sys","code","handleInitStack","extend","autoComplete","prototype","init","sc","ctrls","so","sv","ctx","connected","k","id","l","push","view","g","data","p","refineItems","clone","selectedNodes","getControl","selectedGroups","selectedGroupsSeparator","selectedNothing","grpSelContainer","locTreeSelContainer","locSelContainer","selectPrompt","typeSelector","chooseAll","chooseAllSelected","selectedNodesCntr","selectedGroupsCntr","inputPool","tree","scope","source","langId","query","BEHAVIOUR","LANGUAGE_ID","pushFuncStack","buildUpDOM","container","style","width","inputs","fake","displaySelectedForm","bindEvents","bindDelegate","tagName","e","gId","resetVariables","toggleCheckBoxes","checked","hide","nothingFound","value","blockingCall","displayPage","GROUP_ID","PreventDefault","bind","lastQuery","QUERY","selectChecked","deSelectChecked","confirm","messages","sureCleanSelected","clearChoosen","bindEvent","show","node","querySelector","className","itemId","parseInt","PARENT_ID","selectedPane","scrollControllerSelected","scrollPaneNative","controls","addPageSelected","debounce","showSelectedNodePage","clear","showSelectedGroups","toggleSelectionAuxCtrls","whenRenderError","message","createNodesByTemplate","whenDropdownToggle","way","pane","hideNothingFound","cleanNode","whenClearToggle","refineQuery","request","type","refineRequest","filter","additionals","1","TYPE_ID","select","VALUE","DISPLAY","2","refineResponce","responce","ETC","PATH_ITEMS","isNotEmptyString","PARENT_ITEM","PATH_NAMES","ITEMS","items","refineItemDataForTemplate","itemData","getRandom","length","i","join","types","toLowerCase","result","selectedAll","all","search","getCacheKeyForQuery","cbItemList","readCheckboxItems","off","util","in_array","on","array_merge","selectItems","checkboxes","querySelectorAll","dropAll","deSelectItems","hasItem","selectLinkItem","unshift","deselectLinkItem","list","kind","makeSelectedItemView","prepend","dontRemoveNode","item","remove","deleteFromArray","random_value","PATH","NAME","smtAdded","absentPath","j","downloadPath","proxy","append","informContentChanged","displayVariants","pageNum","displayedIndex","displayedItems","domItem","whenRenderVariant","appendChild","fireEvent","showDropdown","onLoad","onComplete","ajax","url","method","dataType","async","processData","emulateOnload","start","REQUEST_TYPE","onsuccess","showError","error","errors","onfailure","op","innerHTML","isElementNode","inputsHTML","serialized","separ","CODE","useCodes","getHTMLByTemplate","=ids","html","checkSmthSelected","getPlural","n","forms","element","elementa","elementov","itemTree","useDynamicLoading","toggle-bundle-before","expander","toggleRoot","manageCeiling","toggleBundle","=PARENT_ID","ID","version","isParent","IS_PARENT","name","is_parent","expander_class","select_class","CNT_BY_FILTER","total"],"mappings":"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"}