import { User } from "../models/IUser.interface";
import { HttpClient } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { IBasicResponse } from "../models/IBasicResponse.interface";
import { Observable } from "rxjs";

@Injectable({ providedIn: "root" })
export class UserService {
  userData = (): User => {
    let userData = localStorage.getItem("userData");
    if (userData) return JSON.parse(userData);
    return new User();
  };

  constructor(private http: HttpClient) {}

  getUserData(userId?: number): Observable<IBasicResponse> {
    let paramUserId = "";
    if (userId) paramUserId = `/${userId}`;
    return this.http.get("user" + paramUserId);
  }

  updateUserData(user: User): Observable<IBasicResponse> {
    return this.http.put("user", user);
  }

  updatePassword(changePasswordData: {
    currentPassword: string;
    newPassword: string;
  }): Observable<IBasicResponse> {
    return this.http.put("password", changePasswordData);
  }

  updateUserRole(
    newRoleCategory: number,
    userId?: number
  ): Observable<IBasicResponse> {
    let paramUserId = "";
    if (userId) paramUserId = `/${userId}`;
    return this.http.put("userRole" + paramUserId, {
      newRoleCategory,
    });
  }
}
