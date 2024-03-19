export interface IUser {
  name: string;
  email: string;
  state_id: string;
  city_id: string;
  address: string;
  houseNumber: string;
  complement: string;
  zipCode: string;
  roles: Array<string>;
}
