class PaginationItem {
    constructor(customOptions, onClickHandler) {
        const defaultOptions = {
            value: '',
            href: '#',
            active: false,
            parent: null,
        };
        const options = {...defaultOptions, ...customOptions};

        this.dom = document.createElement('li');
        this.dom.classList.add('page-item');
        this.onClickHandler = onClickHandler || null;
        this.options = options;
        if (this.options.active) {
            this.dom.classList.add('active');
        }

        const a = document.createElement('a');
        a.classList.add('page-link');
        a.setAttribute('href', this.options.href);
        a.textContent = this.options.value;

        if (this.onClickHandler) {
            a.addEventListener('click', this.onClickEvent.bind(this));
        }

        this.dom.appendChild(a);
    }

    onClickEvent(event) {

        const activeItem = this.options.parent.element.querySelector('.active');
        if (activeItem) {
            activeItem.classList.remove('active');
        }

        this.setActive();

        this.onClickHandler(event, {
            value: this.options.value
        });
    }

    setActive() {
        this.dom.classList.add('active');
    }

    get element() {
        return this.dom;
    }

}

class Pagination {
    constructor(total, offset, limit, onClickHandler, customOptions) {
        const defaultOptions = {
            activePage: 0,
            textInput: true,
            maxItemLength: 10
        };
        const options = {...defaultOptions, ...customOptions};

        this.dom = document.createElement('ul');
        this.dom.classList.add('pagination');
        this.totalVisiblePages = 10;
        this.items = [];
        this.currentItem = null;
        this.pages = Math.ceil(total / limit);

        if (this.pages > 0) {
            const firstItemPage = document.createElement('li');
            firstItemPage.classList.add('page-item');
            const firstItem = document.createElement('a');
            firstItem.classList.add('page-link');
            firstItem.setAttribute('href', '#');
            firstItem.textContent = 'FIRST';
            firstItemPage.appendChild(firstItem);
            this.dom.appendChild(firstItemPage);
            firstItem.addEventListener('click', this.firstItem.bind(this));

            const previousItemPage = document.createElement('li');
            previousItemPage.classList.add('page-item');
            const previousItem = document.createElement('a');
            previousItem.classList.add('page-link');
            previousItem.setAttribute('href', '#');
            previousItem.textContent = '«';
            previousItemPage.appendChild(previousItem);
            this.dom.appendChild(previousItemPage);
            previousItem.addEventListener('click', this.previousItem.bind(this));

            if (this.pages > options.maxItemLength) {
                const middle = Math.ceil(this.totalVisiblePages/2);
                for(let i = 0; i<this.totalVisiblePages; i+=1) {


                    const validItem = (i < 3 || i >= this.totalVisiblePages-3);
                    if (validItem) {
                        const index = i < (middle) ? i : (this.pages - (this.totalVisiblePages-(i)));
                        this.createItem(index+1, index === options.activePage, onClickHandler);
                    } else {
                        if (middle === i) {
                            this.dom.appendChild(this.dots);

                            if (options.textInput) {
                                this.dom.appendChild(this.textInput);
                                this.dom.appendChild(this.dots);
                            }
                        }
                    }
                }
            } else {
                for(let i = 0; i < this.pages; i+=1) {
                    this.createItem(i+1, i === options.activePage, onClickHandler);
                }
            }

            const nextItemPage = document.createElement('li');
            nextItemPage.classList.add('page-item');
            const nextItem = document.createElement('a');
            nextItem.classList.add('page-link');
            nextItem.setAttribute('href', '#');
            nextItem.textContent = '»';
            nextItemPage.appendChild(nextItem);
            this.dom.appendChild(nextItemPage);
            nextItem.addEventListener('click', this.nextItem.bind(this));

            this.currentItem = this.items[1];
            const lastItemPage = document.createElement('li');
            lastItemPage.classList.add('page-item');
            const lastItem = document.createElement('a');
            lastItem.classList.add('page-link');
            lastItem.setAttribute('href', '#');
            lastItem.textContent = 'LAST';
            lastItemPage.appendChild(lastItem);
            this.dom.appendChild(lastItemPage);
            lastItem.addEventListener('click', this.lastItem.bind(this));


        }
    }

    createItem (value, status, onClickHandler) {
        const item = new PaginationItem({
            value: value,
            active: status,
            parent: this,
        }, onClickHandler);
        this.items[value] = item;
        this.dom.appendChild(item.element);
    }

    get dots() {
        const li = document.createElement('li');
        li.classList.add('page-item');
        const dots = document.createElement('span');
        dots.classList.add('page-link');
        dots.textContent = '...';
        li.appendChild(dots);

        return li;
    }
    get textInput() {
        const li = document.createElement('li');
        li.classList.add('page-item');
        const span = document.createElement('span');
        span.classList.add('page-link');
        const textInput = document.createElement('input');
        textInput.classList.add('pagination__input');
        textInput.addEventListener('keydown', this.onInputEvent.bind(this));
        span.appendChild(textInput);
        li.appendChild(span);

        return li;
    }

    onInputEvent(event) {
        const item = parseInt(event.target.value, 10) || 1;
        if(event.keyCode === 13) {
            this.items[item].onClickEvent(event);
            this.currentItem = this.items[item];
        }
    }

    get element() {
        return this.dom;
    }
    firstItem(event) {
        this.items[1].onClickEvent(event);
        this.currentItem = this.items[1];
    }
    lastItem(event) {
        this.items[this.pages].onClickEvent(event);
        this.currentItem = this.items[this.pages];
    }
    nextItem(event) {
        const currentIndex = parseInt(this.currentItem.options.value, 10);
        if (currentIndex <= this.pages && this.items[currentIndex+1]) {
            this.items[currentIndex+1].onClickEvent(event);
            this.currentItem = this.items[currentIndex+1];
        }

    }
    previousItem(event) {
        const currentIndex = parseInt(this.currentItem.options.value, 10);
        if (currentIndex > 0 && this.items[currentIndex-1]) {
            this.items[currentIndex-1].onClickEvent(event);
            this.currentItem = this.items[currentIndex-1];
        }
    }
}

/*
* Pagination init
* */
const paginationEl = document.querySelector('.pagination');

const limit = parseInt(paginationEl.getAttribute('data-limit'), 10);
const offset = parseInt(paginationEl.getAttribute('data-offset'), 10);
const total = parseInt(paginationEl.getAttribute('data-total'), 10);
const activePage = 0;
const onClickCallback = (event, params) => {
  alert(`Item ${params.value} was selected! `);
};
const promoCardsPagination = new Pagination(total, offset, limit, onClickCallback);
paginationEl.appendChild(promoCardsPagination.element)