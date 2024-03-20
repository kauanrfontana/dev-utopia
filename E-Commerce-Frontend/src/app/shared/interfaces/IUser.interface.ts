export interface IUser {
  name: string;
  email: string;
  stateId: number;
  cityId: number;
  address: string;
  houseNumber: string;
  complement: string;
  zipCode: string;
  roles: Array<string>;
}
