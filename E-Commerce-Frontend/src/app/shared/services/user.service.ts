import { IUser } from "./../interfaces/IUser.interface";
import { HttpClient } from "@angular/common/http";
import { Injectable } from "@angular/core";

@Injectable({ providedIn: "root" })
export class UserService {
  constructor(private http: HttpClient) {}

  getUserData(userId?: number) {
    let paramUserId = "";
    if (userId) paramUserId = `/${userId}`;
    return this.http.get("user" + paramUserId);
  }

  updateUserData(user: IUser) {
    return this.http.put("user", user);
  }
}
