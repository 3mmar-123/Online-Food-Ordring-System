class SearchBoxOptions {
    mode = SearchBox.SELECTBOX;
    showArrow = true;
    hasSecondary = false;
    multiple = false;

    labelText = null;
}

class SearchBox {
    static SELECTBOX = 1;

    static SEARCHBOX = 2;
    static ycParentClass = 'yc-popover-parent';
    static ycOutputPrefixClass = 'yc-popover-output-prefix';
    static ycOutputClass = 'yc-popover-output';
    static ycInputClass='yc-popover-input';
    static ycItemsContainerClass='yc-popover-items-container';
    #originalTag;
    #searchBoxParent;
    dataset;
    disabled=false;
    #processedDataSet;
    mode;
    showArrow;
    hasSecondary;
    multiple;
    labelText;
    outputBox;
    outputBoxPrefixTag;
    inputBox;
    itemsContainer;
    unmatchedElements = [];
    #prevSearchValue;
    #currentSearchValue;

    constructor(searchBox = null, dataset = null, options = null) {
        if (!searchBox)
            return;
        if (options == null) {
            options = new SearchBoxOptions();
        }
        this.#originalTag = searchBox;
        this.dataset = dataset;
        this.multiple = options.multiple;
        this.showArrow = options.showArrow;
        this.mode = options.mode;
        this.labelText = options.labelText;
        this.hasSecondary = options.hasSecondary;
        if (options.showArrow == null) {
            this.showArrow = options.mode == SearchBox.SELECTBOX;
        }
        if (options.mode === SearchBox.SEARCHBOX && dataset == null) {
            throw new Error('dataset must be given for SEARCHBOX mode');
        }
        this.initialize();
    }

    static createSelectDropdown(searchBox, options = null) {
        if( typeof searchBox == "string"){
            $(searchBox).each(function(){
                SearchBox.createSelectDropdown(this);
            });
            return ;
        }
        if (options == null) {
            options = new SearchBoxOptions();
            options.mode = SearchBox.SELECTBOX;
            options.showArrow = true;
            options.hasSecondary = searchBox.querySelector('option[data-secondary]') != null;
        }
        return new SearchBox(searchBox, searchBox.options, options)

    }

    initialize() {
        this.initializeDataset();
        this.prepareSearchBox();
    }

    static extendSelect(tag, newId = null, extend = null) {


        let searchBox = new SearchBox();
        console.log(extend,searchBox)
        if (extend) {
            searchBox.extendOptions(extend);
        }
        searchBox.#originalTag = tag;
        let parent = tag.parentElement;
        console.log(extend,searchBox)
        if (parent && parent.classList.contains(SearchBox.ycParentClass)) {
            searchBox.#searchBoxParent = parent;

            if (searchBox.unmatchedElements.length < 1) {
                searchBox.dataset = searchBox.dataset ?? tag.options;
                searchBox.initializeDataset();
            }
            searchBox.outputBox = parent.querySelector('input.' + SearchBox.ycOutputClass);
            searchBox.outputBoxPrefixTag = parent.querySelector('.' + SearchBox.ycOutputPrefixClass);
            if (!searchBox.outputBox) {
                searchBox.prepareSearchBox();
            } else {
                console.log('prevId=' + searchBox.outputBox.id);

                searchBox.outputBox.id = (newId ?? searchBox.outputBox.id ?? SearchBox.ycOutputClass) + (document.getElementsByClassName(SearchBox.ycOutputClass).length + 1);
                console.log('newId=' + searchBox.outputBox.id);
                searchBox.inputBox=$(parent).find('.'+SearchBox.ycInputClass)[0];
                searchBox.itemsContainer=$(parent).find('.'+SearchBox.ycItemsContainerClass)[0];
                let label = searchBox.outputBox.nextElementSibling;
                if (label && label.tagName == 'label') {
                    label.for = searchBox.outputBox.id;
                }
                searchBox.setLestiners();
            }
        }


    }

    initializeDataset() {
        let items = [];
        let dataset = this.dataset;
        if (!dataset) {
            dataset = this.#originalTag;
        }
        if (dataset instanceof HTMLOptionsCollection) {
            dataset = Array.from(dataset);
        }

        if (dataset instanceof Element && dataset.tagName.toLowerCase() === "select") {
            let options = dataset.options;
            for (let i = 0; i < options.length; i++) {
                let dataPoint = options[i];
                const item = document.createElement("DIV");
                item.classList.add("select-option")
                item.setAttribute('data-value', dataPoint.getAttribute('value') ?? '');
                item.setAttribute('data-index', i);
                let itemChkbx = "";
                if (this.multiple) {
                    itemChkbx = `<input type="checkbox" class="form-check-input" autocompleted="">`;
                }

                let secondaryText = '';
                if (this.hasSecondary && $(dataPoint).data('secondary')) {
                    secondaryText = `<span class="select-option-secondary-text">${$(dataPoint).data('secondary')}</span>`
                }

                $(item).append(`<span class="select-option-text">${itemChkbx}${dataPoint.textContent}${secondaryText}</span>`);
                if (dataPoint.selected)
                    item.classList.add('selected');
                items[i] = item;
            }

        } else if (dataset instanceof Array) {
            let _this = this;
            dataset.forEach(function (dataPoint, i) {
                let primaryText;
                let secondaryText;
                const item = document.createElement("DIV");
                item.classList.add("select-option")
                item.setAttribute('data-index', i);
                if (dataPoint instanceof Element && dataPoint.tagName.toLowerCase() === "option") {
                    primaryText = dataPoint.innerText;
                    secondaryText = $(dataPoint).data('secondary');
                    item.setAttribute('data-value', dataPoint.getAttribute('value') ?? '');
                } else if (typeof dataPoint == 'string') {
                    primaryText = dataPoint;
                    secondaryText = null;
                    item.setAttribute('data-value', primaryText);


                } else if (dataPoint instanceof Array) {
                    primaryText = dataPoint[0];
                    secondaryText = dataPoint[1];
                    item.setAttribute('data-value', primaryText);
                } else if (dataPoint instanceof Object) {
                    primaryText = dataPoint.primary;
                    secondaryText = dataPoint.secondary;
                    item.setAttribute('data-value', primaryText);


                } else {
                    console.log('Unknown dataPoint', dataPoint, typeof dataPoint);
                    primaryText = dataPoint;
                    item.setAttribute('data-value', primaryText);

                }
                let itemChkbx = "";
                if (_this.multiple) {
                    itemChkbx = `<input type="checkbox" class="form-check-input" >`;
                }
                let secondarySpan = '';
                if (_this.hasSecondary && secondaryText) {
                    secondarySpan = `<span class="select-option-secondary-text">${secondaryText}</span>`
                }
                if (primaryText) {
                    $(item).append(`<span class="select-option-text">${itemChkbx}${primaryText}${secondarySpan}</span>`);

                    // $(item).append(`<span class="select-option-text">${primaryText}</span>`);
                    // if (this.hasSecondary) {
                    //     $(item).append(`<span class="select-option-text">${primaryText}<span class="select-option-secondary-text">${secondaryText}</span></span>`)
                    // } else
                    //     $(item).append(`<span class="select-option-text">${primaryText}</span>`);

                    items[i] = item;
                }
            });
            // for (let i = 0; i < dataset.length; i++) {
            //     let dataPoint = dataset[i];
            //     let primaryText;
            //     let secondaryText;
            //     const item = document.createElement("DIV");
            //     item.classList.add("select-option")
            //     item.setAttribute('data-index', i);
            //     if (dataset instanceof Element && dataset.tagName.toLowerCase() === "option")
            //     {
            //         primaryText = dataPoint.innerText;
            //         secondaryText = $(dataPoint).data('secondary');
            //         item.setAttribute('data-value', dataPoint.getAttribute('value') ?? '');
            //     }
            //
            //     else if (typeof dataPoint == 'string') {
            //         primaryText = dataPoint;
            //         secondaryText = null;
            //         item.setAttribute('data-value', primaryText);
            //
            //
            //     } else if (dataPoint instanceof Array) {
            //         primaryText = dataPoint[0];
            //         secondaryText = dataPoint[1];
            //         item.setAttribute('data-value', primaryText);
            //     } else if (dataPoint instanceof Object) {
            //         primaryText = dataPoint.primary;
            //         secondaryText = dataPoint.secondary;
            //         item.setAttribute('data-value', primaryText);
            //
            //
            //     } else {
            //         console.log('Unknown dataPoint', dataPoint, typeof dataPoint);
            //         primaryText = dataPoint;
            //         item.setAttribute('data-value', primaryText);
            //
            //     }
            //     let itemChkbx = "";
            //     if (this.multiple) {
            //         itemChkbx = `<input type="checkbox" class="form-check-input" >`;
            //     }
            //     let secondarySpan = '';
            //     if (this.hasSecondary && secondaryText) {
            //         secondarySpan = `<span class="select-option-secondary-text">${secondaryText}</span>`
            //     }
            //     if (primaryText) {
            //         $(item).append(`<span class="select-option-text">${itemChkbx}${primaryText}${secondarySpan}</span>`);
            //
            //         // $(item).append(`<span class="select-option-text">${primaryText}</span>`);
            //         // if (this.hasSecondary) {
            //         //     $(item).append(`<span class="select-option-text">${primaryText}<span class="select-option-secondary-text">${secondaryText}</span></span>`)
            //         // } else
            //         //     $(item).append(`<span class="select-option-text">${primaryText}</span>`);
            //
            //         items[i] = item;
            //     }
            // }
        } else {
            console.log('typeof', typeof dataset, dataset)
        }
        this.#processedDataSet = items;
        this.unmatchedElements = items;
    }

    prepareSearchBox() {
        let sbParent = this.#originalTag.parentElement;
        if (this.mode == SearchBox.SELECTBOX) {
            this.#originalTag.className = 'select select-initialized';
            this.outputBox = document.createElement('input');
            this.outputBox.id = "searchable-box-" + this.#originalTag.id + Math.random().toString(36).substr(2, 5);
            $(this.#originalTag).replaceWith(this.outputBox);

        } else {
            this.outputBox = this.#originalTag;
        }
        if (!sbParent.classList.contains('form-outline')) {
            let inputWrap = document.createElement("DIV");
            inputWrap.classList.add('form-outline');
            this.outputBox.classList.add('form-control', 'form-input');

            $(this.outputBox).replaceWith(inputWrap);
            inputWrap.appendChild(this.outputBox);
            if (this.mode == SearchBox.SELECTBOX) {
                inputWrap.appendChild(this.#originalTag);
            }
            if (this.labelText) {
                let label = document.createElement('label');
                label.className = 'form-label';
                label.innerText = this.labelText;
                this.outputBox.id = this.outputBox.id ?? "searchable-box-" + this.labelText + Math.random().toString(36).substr(2, 5);
                label.for = this.outputBox.id;
                $(this.outputBox).after(label);
            }
            this.#searchBoxParent = inputWrap;
        } else {
            if (this.mode == SearchBox.SELECTBOX) {
                let label = $(sbParent).find('label').first();
                this.outputBox.classList.add('form-control', 'select-input');

                if (label)
                    label.attr('for', this.outputBox.id);
                sbParent.appendChild(this.#originalTag);
            }
            this.#searchBoxParent = sbParent;
        }
        if (this.showArrow) {
            $(this.#searchBoxParent).append('<span class="select-arrow"></span>');
        }
        if(this.hasSecondary){
            this.outputBoxPrefixTag=document.createElement('span');
            this.outputBoxPrefixTag.className="yc-prefix prefix-scrollable "+SearchBox.ycOutputPrefixClass;
            this.outputBoxPrefixTag.dataset.toggle="tooltip";
            this.outputBox.classList.add('form-prefix-scrollable');
            $(this.outputBox).before(this.outputBoxPrefixTag);
        }
        this.#searchBoxParent.classList.add(SearchBox.ycParentClass);
        this.outputBox.classList.add(SearchBox.ycOutputClass);
        let resultDropdown = document.createElement("div");
        resultDropdown.classList.add("select-dropdown-container");
        const dropdown = document.createElement("DIV");
        dropdown.classList.add("select-dropdown", "d-none");
        resultDropdown.appendChild(dropdown);

        const itemsWrap = document.createElement("DIV");
        itemsWrap.classList.add("select-options-wrapper");
        const items = document.createElement("DIV");
        items.classList.add("select-options-list");
        items.classList.add(SearchBox.ycItemsContainerClass);
        itemsWrap.appendChild(items);
        let emptyList = document.createElement('span');
        emptyList.innerText = 'لا يوجد نتائج!';
        let _this = this;
        let inputTag;

        if (this.mode == SearchBox.SELECTBOX) {
            this.outputBox.readOnly = "true";
            inputTag = document.createElement('input');
            inputTag.classList.add('form-control', 'select-filter-input');
            inputTag.setAttribute('role', 'searchbox');
            inputTag.placeholder = 'بحث...';
            dropdown.appendChild(inputTag);
            if (this.multiple) {
                const item = $(`<div class="select-option select-all-option" role="option" aria-selected="false" style="height: 38px;">
                    <span class="select-option-text"><input type="checkbox" class="form-check-input" autocompleted="">تحديد الكل</span>
                </div>`);
                $(items).before(item);
            }
        } else {
            inputTag = this.outputBox;


        }
        inputTag.classList.add(SearchBox.ycInputClass)


        dropdown.appendChild(itemsWrap);

        let selectWrap = document.createElement("DIV");
        selectWrap.classList.add("select-wrapper");
        this.inputBox=inputTag;
        this.itemsContainer=items;
        this.#searchBoxParent.appendChild(resultDropdown);

        this.setLestiners();

        if (this.mode == SearchBox.SELECTBOX)
            this.unmatchedElements.forEach(function (item, i) {
                if (item.classList.contains('selected')) {
                    items.appendChild(item);
                    item.click();
                }
            })
        document.addEventListener("click", closeAllSelect);

    }

    resetDataSet(newdataset, hasSecondary = false) {
        this.dataset = newdataset;
        this.hasSecondary = hasSecondary;
        this.initializeDataset();
    }

    extendOptions(options) {
        this.mode = options.mode ?? this.mode;
        this.unmatchedElements = options.unmatchedElements ?? this.unmatchedElements;
        this.hasSecondary = options.hasSecondary ?? this.hasSecondary;
        this.showArrow = options.showArrow ?? this.showArrow;
        this.dataset = options.dataset ?? this.dataset;
        this.#processedDataSet = options.processedDataSet ?? this.#processedDataSet;
        this.multiple = options.multiple ?? this.multiple;
    }

    cloneOptions() {
        return {
            mode: this.mode,
            showArrow: this.showArrow,
            hasSecondary: this.hasSecondary,
            multiple: this.multiple,
            unmatchedElements: this.unmatchedElements,
            processedDataSet: this.#processedDataSet,
            dataset: this.dataset
        };
    }

    selectOption(value) {
        console.log('auto select',value);
        if(value&&this.mode==SearchBox.SELECTBOX){
            console,log('auto select passed',value);
            this.#originalTag.value=value;
            $(this.#originalTag).change();
        }
        if (!this.multiple) {
            for (let i = 0; i < this.unmatchedElements.length; i++) {
                if ($(this.unmatchedElements[i]).data('value') == value) {
                    if (!this.unmatchedElements[i].isConnected) {
                        let list = $(this.#searchBoxParent).find('.select-options-list');
                        list.append(this.unmatchedElements[i]);
                    }

                    this.unmatchedElements[i].classList.toggle('selected', false);
                    this.unmatchedElements[i].click();
                    break;
                }
            }
        }
    }


    setLestiners() {
        let _this=this;
        let dropdown=_this.#searchBoxParent.querySelector('.select-dropdown');

        $(this.outputBox).on('keydown', function (e){
            console.log('outputBox keydown');
            this.click(e);
        });
        $(this.outputBox).on('focused', function (e){
            console.log('outputBox focused',e);
            this.click(e);
        });
        $(this.inputBox).on('keydown', function (e) {
            if(_this.#originalTag.hasAttribute('disabled') ){
                return true;
            }
            if (e.keyCode === 40 || e.keyCode === 38) {
                e.preventDefault();
                if(_this.#originalTag.hasAttribute('disabled') ){
                    return true;
                }
                let selectedItem = _this.itemsContainer.querySelector('.select-option.selected');
                let newSelectedItem;
                if (selectedItem) {
                    if (e.keyCode === 40) {
                        newSelectedItem = selectedItem.nextElementSibling ?? _this.itemsContainer.firstElementChild;

                    } else {
                        newSelectedItem = selectedItem.previousElementSibling ?? _this.itemsContainer.lastElementChild;
                    }
                    selectedItem.classList.remove('selected');

                } else {
                    newSelectedItem = _this.itemsContainer.firstElementChild;
                }
                if (newSelectedItem) {
                    newSelectedItem.classList.add('selected');
                    newSelectedItem.focus();
                    newSelectedItem.scrollIntoView(false);
                }
                return false;
            }

        });

        this.outputBox.addEventListener('click', function (e) {
            e.stopPropagation();
            if(_this.#originalTag.hasAttribute('disabled') ){
                return;
            }
            let open = !dropdown.classList.contains('open');
            closeAllSelect();

            if (open) {
                dropdown.classList.toggle('open',);
                this.classList.toggle('focused');
                dropdown.classList.toggle('d-none');
                $(_this.inputBox).focus();
            }
            this.classList.toggle('active', this.value != '');
            if(_this.inputBox.value != ''){
                return true;
            }
            _this.unmatchedElements.forEach(function (item) {
                _this.itemsContainer.appendChild(item);
            })
        })
        $(this.inputBox).on('keyup', function (e) {
            e.stopPropagation();
            if(_this.#originalTag.hasAttribute('disabled') ){
                return true;
            }
            dropdown.classList.toggle('open', true);
            dropdown.classList.toggle('d-none', false);

            let val = $(this).val().toLowerCase();
            if (val == '' && _this.mode === SearchBox.SEARCHBOX) {
                dropdown.classList.toggle('open');
                dropdown.classList.toggle('d-none');
                return true;
            }
            if (e.keyCode === 13) {
                let selectedItem = _this.itemsContainer.querySelector('.select-option.selected .select-option-text');
                if (selectedItem) {
                    selectedItem.click();
                }
                return false;
            }

            _this.itemsContainer.innerHTML = '';
            for (let i = 0; i < _this.unmatchedElements.length; i++) {
                const element = _this.unmatchedElements[i];
                let aIndex = element.textContent.toLowerCase().indexOf(val);
                if (aIndex > -1) {
                    let j = 0;
                    for (j = 0; j < _this.itemsContainer.children.length; j++) {
                        let bIndex = _this.itemsContainer.children[j].textContent.toLowerCase().indexOf(val);
                        if (bIndex > aIndex) {
                            aIndex = bIndex;
                            $(_this.itemsContainer.children[j]).before(element)
                            break;
                        }
                    }
                    if (j === _this.itemsContainer.children.length) {
                        _this.itemsContainer.appendChild(element);
                    }
                }

            }
            if (!_this.multiple && !_this.itemsContainer.querySelector('.select-option.selected') && _this.itemsContainer.children.length > 0) {
                _this.itemsContainer.children[0].classList.add('selected');
                _this.itemsContainer.children[0].focus();
            }
        });
        _this.itemsContainer.addEventListener('click', function (e) {
            if(_this.#originalTag.hasAttribute('disabled') ){
                return true;
            }
            let option = $(e.target).closest('.select-option')[0];
            if (option) {
                if (_this.multiple) {

                    if ($(option).hasClass('select-all-option')) {
                        $(option).toggleClass('selected');
                        let checked = $(option).hasClass('selected');
                        _this.itemsContainer.querySelectorAll('.select-option span input[type="checkbox"]').forEach(function (chkItem) {
                            if ((chkItem.checked && !checked) || (!chkItem.checked && checked)) {
                                chkItem.parentElement.parentElement.classList.toggle('selected', checked);
                                chkItem.checked = checked;
                                if (checked)
                                    _this.outputBox.value = _this.outputBox.value + ' , ' + option.childNodes[1].textContent;
                                else
                                    _this.outputBox.value = _this.outputBox.value.replace(option.childNodes[1].textContent, '');
                                _this.#originalTag.options[option.data('index')].selected = checked;

                            }
                        });
                    } else {
                        $(option).toggleClass('selected');
                        let ck = $(option).find('input[type="checkbox"]');
                        let checked = $(option).hasClass('selected');
                        if (checked)
                            _this.outputBox.value = _this.outputBox.value + ' , ' + option.childNodes[1].textContent;
                        else
                            _this.outputBox.value = _this.outputBox.value.replace(option.childNodes[1].textContent, '');
                        _this.#originalTag.options[$(option).data('index')].selected = checked;
                        ck.prop('checked', checked);
                    }
                } else {
                    let prevSelected = _this.itemsContainer.querySelector('.select-option.selected');
                    if (prevSelected) {
                        prevSelected.classList.remove('selected');
                    }
                    $(option).toggleClass('selected', true);

                    for(let i=0;i<option.childNodes.length;i++){
                        if (option.childNodes[i].nodeName == '#text') {

                            _this.outputBox.value = option.childNodes[i].textContent;
                            break;
                        }
                    }
                    //_this.outputBox.value = option.childNodes[0].textContent;
                    _this.outputBox.classList.toggle('focused',false)
                    dropdown.classList.toggle('open', false);
                    dropdown.classList.toggle('d-none', true);
                    if (_this.mode === SearchBox.SELECTBOX) {
                        // _this.#originalTag.options[$(option).data('index')].selected = true;
                        _this.#originalTag.selectedIndex = $(option).data('index');
                        $( _this.#originalTag).change();
                    }

                }

            } else {
                _this.outputBox.classList.toggle('focused')
                dropdown.classList.toggle('open');
                dropdown.classList.toggle('d-none');
            }
            _this.outputBox.classList.toggle('active', _this.outputBox.value != '')
            // _this.outputBox.classList.toggle('active', _this.outputBox.value!='')
        });
        if(this.mode==SearchBox.SELECTBOX){
            $(this.#originalTag).on('change', function (e){
                _this.outputBox.value = _this.#originalTag.selectedOptions[0].innerText;
                if(_this.hasSecondary) {
                    _this.outputBox.classList.toggle('form-prefix',true);
                    _this.outputBoxPrefixTag.innerHTML = _this.#originalTag.selectedOptions[0].dataset.secondary??'';
                    _this.outputBoxPrefixTag.title = _this.#originalTag.selectedOptions[0].dataset.secondary??'';
                }
            });

            let option= _this.#originalTag.selectedOptions[0];
            if(option){

                _this.outputBox.value = option.innerText;
                _this.outputBox.classList.add('active')
                if(_this.hasSecondary) {
                    _this.outputBox.classList.toggle('form-prefix',true);
                    _this.outputBoxPrefixTag.innerHTML = option.dataset.secondary??'';
                    _this.outputBoxPrefixTag.title = option.dataset.secondary??'';
                }
            }


        }

    }
}


function closeAllSelect(current) {
    const selectSelected = document.querySelectorAll(".select-dropdown.open:not(.d-none)");
    document.querySelectorAll('.'+SearchBox.ycOutputClass+'.focused').forEach((item,i)=>{
        item.classList.toggle('focused');
    })
    selectSelected.forEach((item, index) => {
        console.log('her it')
        console.log($(item).parent().parent().closest('.'+SearchBox.ycOutputClass))
        $(item).parent().parent().closest('.'+SearchBox.ycOutputClass).removeClass('.focused');
        if (current !== item) {
            item.classList.remove("open");
            item.classList.add("d-none");
        }
    });
}

