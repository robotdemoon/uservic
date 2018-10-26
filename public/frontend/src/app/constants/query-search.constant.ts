export class SearchData {
    constructor(
        public query: string = '',
        public l_query: string = '',
        public filter: boolean = true,
        public more: boolean = true,
        public data: any = []
    ){}
}


/**
 * [Constante de navegacion]
 * [query = variable de url, l_query = last query: url previa, filter = variable del
 * filtro utilizada para saber el filtro actual, more = variable para el estado del scroll cuando se requieran mas items, data = variable que guarda los items en caso de que el filtro y la query sean el mismo]
 */

export const searchData = new SearchData;