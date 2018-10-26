export class Budget {
    constructor(
        public costumer: number = null,
        public service: number = null,
        public title: string = '',
        public total: number = 0.00
    ){}
}

export class BudgetService {
    constructor(
        public name: string = '',
        public cost: number = 0.00,
        public number: number = 0,
        public total: number = 0.0,
        public description: string = ''
    ){}
}