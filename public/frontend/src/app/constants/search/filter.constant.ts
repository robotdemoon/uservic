export class Filter {
    constructor(
        public business_days: string = '',
        public open: string = null,
        public close: string = null,
        public category: string = '',
        public experience: number = 0,
        public type_service: string = '',
        public type_cost: string = '',
        public type_money: string = '',
        public country: number = 0,
        public state: number = 0,
        public city: number = 0,
        public cost: number = 0
    ){}
    
}

export const filter = new Filter;
