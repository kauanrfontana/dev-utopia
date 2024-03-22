export class User {
  constructor(
    public name: string = "",
    public email: string = "",
    public stateId: number = 0,
    public cityId: number = 0,
    public address: string = "",
    public houseNumber: string = "",
    public complement: string = "",
    public zipCode: string = "",
    public role: string = "",
    public roleCategory: number = 0
  ) {}
}
