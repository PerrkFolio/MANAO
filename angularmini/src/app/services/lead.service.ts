import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, throwError } from 'rxjs';
import { map, catchError } from 'rxjs/operators';
import { environment } from 'src/environments/environment';
import { Lead } from '../models/lead';
import { ResponseHttp } from '../models/responseHttp';

@Injectable({
  providedIn: 'root'
})
export class LeadService {
  
  getLeads(): Observable<Lead[]> {
    return this.http.get<ResponseHttp>(environment.apiUrl + 'api/leads').pipe(
      map((data) => {
        return data.data.items;
      }),
      catchError((error) => {
        return throwError(error)
      })
    )
  }
  
  getLead(id: number) : Observable<Lead> {
    return this.http.get<ResponseHttp>(environment.apiUrl + 'api/leads/' + id).pipe(
      map((data) => {
        return data.data.item;
      }),
      catchError((error) => {
        return throwError(error)
      })
    )
  }

  updateLead(lead: Lead) : Observable<Lead> {
    return this.http.put<ResponseHttp>(environment.apiUrl + 'api/leads/' + lead.id, lead).pipe(
      map((data) => {
        return data.data.item;
      }),
      catchError((error) => {
        return throwError(error)
      })
    )
  }
  storeLead(lead: Lead) : Observable<Lead> {
    return this.http.post<ResponseHttp>(environment.apiUrl + 'api/leads', lead).pipe(
      map((data) => {
        return data.data.item;
      }),
      catchError((error) => {
        return throwError(error)
      })
    )
  }

  constructor(private http: HttpClient) { }
}
