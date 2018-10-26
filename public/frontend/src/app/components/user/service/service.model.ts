/**
 * [Objeto par Crear Servicio]
 */
export class Service {
    constructor(
        public name_service: string = '',
        public category: string = '',
        public experience: number = 0,
        public type_service: string = '',
        public type_cost: string = '',
        public cost: number = 10000,
        public type_money: string = '',
        public business_days: string = '',
        public open: string = '',
        public close: string = '',
        public country: number = 0,
        public state: number = 0,
        public city: number = 0,
        public description: string = '',
        public image: string = 'nopicture.jpg',
        public status: string = 'Active'
    ){}
}

export class Contact {
    constructor(
        public order: number,
        public id: number = null,
        public status: string = '',
        public type: string = '',
        public method: string = ''
    ){}
}
