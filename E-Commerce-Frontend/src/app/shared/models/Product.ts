export class Product {
  constructor(
    public id: number = 0,
    public name: string = "",
    public price: number = 0,
    public description: string = "",
    public urlImage: string = "",
    public stateId: number = 0,
    public cityId: number = 0,
    public address: string = "",
    public houseNumber: string = "",
    public complement: string = "",
    public zipCode: string = ""
  ) {}
}
