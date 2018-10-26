/**
 * [Objeto para Login]
 */

export class UserL {
    constructor(
        public email: string = '',
        public password: string = ''
    ){}
}

/**
 * [Objeto para Registro]
 */
export class UserS {
    constructor(
        public fullname: string = '',
        public username: string = '',
        public email: string = '',
        public age: number = 18,
        public country: number = 0,
        public scholarship: string = '',
        public sector: string = '',
        public password: string = ''
    ){}
}