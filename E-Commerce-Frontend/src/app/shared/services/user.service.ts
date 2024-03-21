import { IUser } from "./../interfaces/IUser.interface";
import { HttpClient } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { IBasicResponse } from "../interfaces/IBasicResponse.interface";
import { Observable } from "rxjs";

@Injectable({ providedIn: "root" })
export class UserService {
  constructor(private http: HttpClient) {}

  getUserData(userId?: number): Observable<IBasicResponse> {
    let paramUserId = "";
    if (userId) paramUserId = `/${userId}`;
    return this.http.get("user" + paramUserId);
  }

  updateUserData(user: IUser): Observable<IBasicResponse> {
    return this.http.put("user", user);
  }

  updatePassword(changePasswordData: {
    currentPassword: string;
    newPassword: string;
  }): Observable<IBasicResponse> {
    return this.http.put("password", changePasswordData);
  }
}
